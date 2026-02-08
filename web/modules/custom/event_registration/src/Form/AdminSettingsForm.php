<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AdminSettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['event_registration.settings'];
  }

  public function getFormId() {
    return 'event_registration_admin_settings_form';
  }

  
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'event_registration/form_styles';

    $config = $this->config('event_registration.settings');

    $form['admin_email'] = [
      '#type' => 'email',
      '#title' => 'Admin Email',
      '#default_value' => $config->get('admin_email'),
      '#required' => TRUE,
    ];

    $form['enable_admin_notification'] = [
      '#type' => 'checkbox',
      '#title' => 'Enable Admin Notification',
      '#default_value' => $config->get('enable_admin_notification'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->configFactory->getEditable('event_registration.settings')
      ->set('admin_email', $form_state->getValue('admin_email'))
      ->set('enable_admin_notification', $form_state->getValue('enable_admin_notification'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}

// A class extending ConfigFormBase.

// Defines the form fields (admin_email, enable_admin_notification).

// Saves values into event_registration.settings config.