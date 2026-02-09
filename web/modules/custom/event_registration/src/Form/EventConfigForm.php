<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

class EventConfigForm extends FormBase {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }
  
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function getFormId() {
    return 'event_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'event_registration/form_styles';

    $form['event_name'] = [
      '#type' => 'textfield',
      '#title' => 'Event Name',
      '#required' => TRUE,
    ];

    $form['category'] = [
      '#type' => 'select',
      '#title' => 'Category',
      '#options' => [
        'online' => 'Online Workshop',
        'hackathon' => 'Hackathon',
        'conference' => 'Conference',
        'one_day' => 'One-day Workshop',
      ],
      '#required' => TRUE,
    ];

    $form['registration_start'] = [
      '#type' => 'date',
      '#title' => 'Registration Start Date',
      '#required' => TRUE,
    ];

    $form['registration_end'] = [
      '#type' => 'date',
      '#title' => 'Registration End Date',
      '#required' => TRUE,
    ];

    
    $form['event_date'] = [
      '#type' => 'date',
      '#title' => 'Event Date',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save Event',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->database->insert('event_config')
      ->fields([
        'event_name' => $form_state->getValue('event_name'),
        'category' => $form_state->getValue('category'),
        'registration_start' => strtotime($form_state->getValue('registration_start')),
        'registration_end' => strtotime($form_state->getValue('registration_end')),
        'event_date' => strtotime($form_state->getValue('event_date')),
        'created' => time(),
      ])
      ->execute();

    $this->messenger()->addMessage('Event saved successfully.');
  }
}
