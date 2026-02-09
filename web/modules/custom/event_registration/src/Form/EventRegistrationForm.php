<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Render\Markup;

class EventRegistrationForm extends FormBase {

  protected $database;
  protected $mailService;

  public function __construct(Connection $database, $mailService) {
    $this->database = $database;
    $this->mailService = $mailService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('event_registration.mail_service')
    );
  }

  public function getFormId() {
    return 'event_registration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'event_registration/form_styles';


    // Fetch available categories

    $categories = $this->getActiveCategories();

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => 'Full Name',
      '#required' => TRUE,
    ];


    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email Address',
      '#required' => TRUE,
    ];

    $form['college_name'] = [
      '#type' => 'textfield',
      '#title' => 'College Name',
      '#required' => TRUE,
    ];

    $form['department'] = [
      '#type' => 'textfield',
      '#title' => 'Department',
      '#required' => TRUE,
    ];

    // CATEGORY DROPDOWN

    $form['category'] = [
      '#type' => 'select',
      '#title' => 'Event Category',
      '#options' => $categories,
      '#empty_option' => 'Select Category',
      '#ajax' => [
        'callback' => '::updateEventDates',
        'wrapper' => 'event-date-wrapper',
      ],
    ];

    // Preserve selected values during rebuilds and force default handling

    $selectedCategory = $form_state->getValue('category') ?? NULL;
    $selectedDate = $form_state->getValue('event_date') ?? NULL;

    // EVENT DATE DROPDOWN
    $form['event_date'] = [
      '#type' => 'select',
      '#title' => 'Event Date',
      '#options' => $this->getEventDatesByCategory($selectedCategory),
      '#empty_option' => 'Select Event Date',
      '#default_value' => $selectedDate,
      '#prefix' => '<div id="event-date-wrapper">',
      '#suffix' => '</div>',
      '#ajax' => [
        'callback' => '::updateEventNames',
        'wrapper' => 'event-name-wrapper',
      ],
    ];

    // EVENT NAME DROPDOWN
    $form['event_name'] = [
      '#type' => 'select',
      '#title' => 'Event Name',
      '#options' => $this->getEventNames($selectedCategory, $selectedDate),
      '#empty_option' => 'Select Event Name',
      '#default_value' => $form_state->getValue('event_name'),
      '#prefix' => '<div id="event-name-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Register',
    ];

    // Add a custom class to the form for styling
    if (!isset($form['#attributes'])) {
      $form['#attributes'] = [];
    }
    $form['#attributes']['class'][] = 'custom-form';

    return $form;
  }

  // --------------------------
  // Fetch Active Categories
  // --------------------------
  private function getActiveCategories() {

    // REMOVE registration date filtering for now
    $query = $this->database->select('event_config', 'e')
      ->fields('e', ['category'])
      ->distinct();

    $results = $query->execute();

    $categories = [];
    foreach ($results as $row) {
      $categories[$row->category] = ucfirst($row->category);
    }

    return $categories;
  }

  // --------------------------
  // AJAX → Update Event Dates
  // --------------------------
  public function updateEventDates(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
    return $form['event_date'];
  }

  private function getEventDatesByCategory($category) {
    if (!$category) return [];

    // REMOVE registration date filtering for now
    $query = $this->database->select('event_config', 'e')
      ->fields('e', ['event_date'])
      ->condition('category', $category)
      ->distinct();

    $results = $query->execute();

    $dates = [];

    foreach ($results as $row) {
      $dates[(int) $row->event_date] = date('Y-m-d', $row->event_date);
    }

    return $dates;
  }

  // --------------------------
  // AJAX → Update Event Names
  // --------------------------
  public function updateEventNames(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
    return $form['event_name'];
  }

  private function getEventNames($category, $event_date) {

    if (!$category || !$event_date) return [];


    $event_date = (int) $event_date; // important cast

    // REMOVE registration date filtering for now
    $query = $this->database->select('event_config', 'e')
      ->fields('e', ['id', 'event_name'])
      ->condition('category', $category)
      ->condition('event_date', $event_date);

    $results = $query->execute();

    $events = [];

    foreach ($results as $row) {
      $events[$row->id] = $row->event_name;
    }

    return $events;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    $name = $form_state->getValue('full_name');
    $college = $form_state->getValue('college_name');
    $department = $form_state->getValue('department');
    $email = $form_state->getValue('email');
    $event_id = $form_state->getValue('event_name');

    // ---------------------
    // Text Validation
    // ---------------------
    $pattern = "/^[a-zA-Z ]+$/";

    if (!preg_match($pattern, $name)) {
      $errorMsg = Markup::create('<strong>⚠️ Special Characters Not Allowed</strong><br><small>Please use only letters and spaces in your name.</small>');
      $form_state->setErrorByName('full_name', $errorMsg);
    }

    if (!preg_match($pattern, $college)) {
      $errorMsg = Markup::create('<strong>⚠️ Special Characters Not Allowed</strong><br><small>Please use only letters and spaces in your college name.</small>');
      $form_state->setErrorByName('college_name', $errorMsg);
    }

    if (!preg_match($pattern, $department)) {
      $errorMsg = Markup::create('<strong>⚠️ Special Characters Not Allowed</strong><br><small>Please use only letters and spaces in your department.</small>');
      $form_state->setErrorByName('department', $errorMsg);
    }

    // ---------------------
    // Duplicate Registration Check
    // ---------------------

    $query = $this->database->select('event_registration', 'r')
      ->fields('r', ['id'])
      ->condition('email', $email)
      ->condition('event_config_id', $event_id);

    // Ensure event id is selected and numeric before querying to avoid SQL errors
    if (empty($event_id) || !is_numeric($event_id)) {
      $form_state->setErrorByName('event_name', 'Please select an event.');
    }
    else {
      $event_id = (int) $event_id;
      $exists = $query->execute()->fetchField();

      if ($exists) {
        $errorMsg = Markup::create('<strong>❌ Already Registered</strong><br><small>You have already registered for this event with this email address.</small>');
        $form_state->setErrorByName('email', $errorMsg);
      }
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $eventId = $form_state->getValue('event_name');

    // Fetch Event Details
    $event = $this->database->select('event_config', 'e')
      ->fields('e')
      ->condition('id', $eventId)
      ->execute()
      ->fetchObject();

    // Insert Registration
    $this->database->insert('event_registration')
      ->fields([
        'full_name' => $form_state->getValue('full_name'),
        'email' => $form_state->getValue('email'),
        'college_name' => $form_state->getValue('college_name'),
        'department' => $form_state->getValue('department'),
        'event_config_id' => $eventId,
        'created' => time(),
      ])
      ->execute();

    // Prepare Email Data
    $mailData = [
      'full_name' => $form_state->getValue('full_name'),
      'email' => $form_state->getValue('email'),
      'event_name' => isset($event->event_name) ? $event->event_name : NULL,
      'event_date' => isset($event->event_date) ? $event->event_date : NULL,
      'category' => isset($event->category) ? $event->category : NULL,
    ];

    // Send confirmation email via injected mail service
    if ($this->mailService && method_exists($this->mailService, 'sendRegistrationMail')) {
      $this->mailService->sendRegistrationMail($mailData);
    }

    $this->messenger()->addMessage('Registration completed successfully.');
  }
}
