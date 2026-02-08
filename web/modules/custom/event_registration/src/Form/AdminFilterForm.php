<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;

class AdminFilterForm extends FormBase implements ContainerInjectionInterface {

  protected $database;
  protected $renderer;

  public function __construct(Connection $database, RendererInterface $renderer) {
    $this->database = $database;
    $this->renderer = $renderer;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('renderer')
    );
  }

  public function getFormId() {
    return 'admin_filter_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['event_date'] = [
      '#type' => 'select',
      '#title' => 'Event Date',
      '#options' => $this->getEventDates(),
      '#default_value' => $form_state->getValue('event_date'),
      '#ajax' => [
        'callback' => '::updateEvents',
        'wrapper' => 'event-name-wrapper',
      ],
    ];

    // If event_date is already selected, populate event_name options
    $eventDate = $form_state->getValue('event_date') ?? NULL;
    $selectedEvent = $form_state->getValue('event_name') ?? NULL;

    $eventNameOptions = $eventDate ? $this->getEventsByDate($eventDate) : [];

    // Ensure selected event remains valid
    if ($selectedEvent && !isset($eventNameOptions[$selectedEvent])) {
      $eventNameOptions[$selectedEvent] = 'Previously selected event';
    }

    $form['event_name'] = [
      '#type' => 'select',
      '#title' => 'Event Name',
      '#options' => $eventNameOptions,
      '#default_value' => $form_state->getValue('event_name'),
      '#prefix' => '<div id="event-name-wrapper">',
      '#suffix' => '</div>',
      '#ajax' => [
        'callback' => '::updateDashboard',
        'wrapper' => 'dashboard-wrapper',
      ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Load Dashboard',
      '#button_type' => 'primary',
      '#attributes' => [
        'class' => ['event-dashboard-load', 'button', 'button--primary'],
      ],
    ];

    // Always build dashboard if event_name is selected (after any submit or AJAX)
    $selectedEventId = $form_state->getValue('event_name');
    if (!empty($selectedEventId)) {
      $form['dashboard'] = $this->buildDashboard($selectedEventId);
      $form['dashboard']['#prefix'] = '<div id="dashboard-wrapper">';
      $form['dashboard']['#suffix'] = '</div>';
    }

    // Attach CSS library for dashboard styling
    $form['#attached']['library'][] = 'event_registration/dashboard';

    return $form;
  }

  // ---------------------
  // Event Dates Dropdown
  // ---------------------
  private function getEventDates() {

    $query = $this->database->select('event_config', 'e')
      ->fields('e', ['event_date'])
      ->distinct();

    $results = $query->execute();

    $dates = [];
    foreach ($results as $row) {
      $dates[$row->event_date] = date('Y-m-d', $row->event_date);
    }

    // Remove duplicate date labels (keeps the first occurrence).
    $dates = array_unique($dates);

    return $dates;
  }

  // ---------------------
  // AJAX → Load Event Names
  // ---------------------
  public function updateEvents(array &$form, FormStateInterface $form_state) {

    $eventDate = $form_state->getValue('event_date');

    $form['event_name']['#options'] = $this->getEventsByDate($eventDate);

    // Ensure form rebuild so dependent AJAX callbacks refresh correctly
    $form_state->setRebuild(TRUE);

    // Return only the updated fragment so Drupal replaces the select correctly
    return $form['event_name'];
  }

  public function updateDashboard(array &$form, FormStateInterface $form_state) {

    $eventId = $form_state->getValue('event_name');

    $form['dashboard'] = $this->buildDashboard($eventId);

    $form['dashboard']['#prefix'] = '<div id="dashboard-wrapper">';
    $form['dashboard']['#suffix'] = '</div>';

    return $form['dashboard'];
  }

  private function getEventsByDate($date) {

    if (!$date) {
      return [];
    }

    // Allow either a numeric timestamp (the normal case) or a Y-m-d string.
    if (is_numeric($date)) {
      $query = $this->database->select('event_config', 'e')
        ->fields('e', ['id', 'event_name'])
        ->condition('event_date', $date);
    }
    else {
      // If a formatted date was submitted (e.g. '2026-02-17'), search for
      // events whose timestamp falls within that day.
      $start = strtotime($date . ' 00:00:00');
      $end = strtotime($date . ' 23:59:59');

      $query = $this->database->select('event_config', 'e')
        ->fields('e', ['id', 'event_name'])
        ->condition('event_date', [$start, $end], 'BETWEEN');
    }

    $results = $query->execute();

    $events = [];
    foreach ($results as $row) {
      $events[$row->id] = $row->event_name;
    }

    return $events;
  }

  private function buildDashboard($eventId) {

    if (!$eventId) {
      return [
        '#markup' => $this->t('No data available.'),
      ];
    }

    $query = $this->database->select('event_registration', 'r')
      ->fields('r')
      ->condition('event_config_id', $eventId);

    $results = $query->execute()->fetchAll();

    $header = [
      $this->t('Name'),
      $this->t('Email'),
      $this->t('College Name'),
      $this->t('Department'),
      $this->t('Submission Date'),
    ];

    $rows = [];

    foreach ($results as $row) {
      $rows[] = [
        $row->full_name,
        $row->email,
        $row->college_name,
        $row->department,
        date('Y-m-d H:i', $row->created),
      ];
    }

    $count = count($rows);

    return [
      'count' => [
        '#markup' => '<h3>Total Participants: ' . $count . '</h3>',
      ],

      'export' => [
        '#type' => 'link',
        '#title' => $this->t('Export CSV'),
        '#url' => \Drupal\Core\Url::fromRoute(
          'event_registration.export_csv',
          ['eventId' => $eventId]
        ),
        '#attributes' => ['class' => ['button', 'button--primary']],
      ],

      
      'table' => [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        '#empty' => $this->t('No registrations found.'),
        '#attributes' => [
          'class' => ['event-dashboard-table'],
        ],
      ],
    ];
  }



  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    // Rebuild the form to display the dashboard

    $form_state->setRebuild(TRUE);
  }
}
