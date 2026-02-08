<?php

namespace Drupal\event_registration\Service;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

class MailService {

  protected $mailManager;
  protected $configFactory;
  protected $logger;

  public function __construct(
    MailManagerInterface $mailManager,
    ConfigFactoryInterface $configFactory,
    LoggerChannelFactoryInterface $loggerFactory
  ) {
    $this->mailManager = $mailManager;
    $this->configFactory = $configFactory;
    $this->logger = $loggerFactory->get('event_registration');
  }

  public function sendRegistrationMail($data) {

    $config = $this->configFactory->get('event_registration.settings');

    $adminEmail = $config->get('admin_email');
    $adminEnabled = $config->get('enable_admin_notification');

    // ---------------------
    // Send User Email
    // ---------------------

    $this->sendMail($data['email'], $data);

    // ---------------------
    // Send Admin Email
    // ---------------------

    if ($adminEnabled && $adminEmail) {
      $this->sendMail($adminEmail, $data);
    }
  }

  private function sendMail($to, $data) {

    $params = [
      'full_name' => $data['full_name'],
      'event_name' => $data['event_name'],
      'event_date' => $data['event_date'],
      'category' => $data['category'],
    ];

    $this->mailManager->mail(
      'event_registration',
      'registration_mail',
      $to,
      'en',
      $params,
      NULL,
      TRUE
    );
  }
}
