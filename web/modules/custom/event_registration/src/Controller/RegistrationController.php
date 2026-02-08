<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\event_registration\Form\AdminFilterForm;

class RegistrationController extends ControllerBase {

  protected $database;
  protected $formBuilder;

  public function __construct(Connection $database, FormBuilderInterface $formBuilder) {
    $this->database = $database;
    $this->formBuilder = $formBuilder;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('form_builder')
    );
  }

  public function registrationPage() {

    // Return the admin filter form; the route defines the page title.
    
    return $this->formBuilder->getForm(AdminFilterForm::class);
  }

  public function exportCsv($eventId) {

    $query = $this->database->select('event_registration', 'r')
      ->fields('r')
      ->condition('event_config_id', $eventId);

    $results = $query->execute()->fetchAll();

    $csvData = [];


    // Header row
    $csvData[] = [
      'Name',
      'Email',
      'College Name',
      'Department',
      'Submission Date',
    ];

    foreach ($results as $row) {
      $csvData[] = [
        $row->full_name,
        $row->email,
        $row->college_name,
        $row->department,
        date('Y-m-d H:i', $row->created),
      ];
    }

    // Convert to CSV string
    $handle = fopen('php://temp', 'r+');

    foreach ($csvData as $line) {
      fputcsv($handle, $line);
    }

    rewind($handle);
    $csvOutput = stream_get_contents($handle);
    fclose($handle);

    $response = new Response($csvOutput);
    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="event_registrations.csv"');

    return $response;
  }
}
