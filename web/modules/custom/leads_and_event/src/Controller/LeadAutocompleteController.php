<?php

namespace Drupal\leads_and_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * LeadAutocompleteController for our leads and event module.
 */
class LeadAutocompleteController extends ControllerBase {

  public function __construct(protected RequestStack $requestStack, protected Connection $database) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('database')
    );
  }

  /**
   * Return the autocomplete response by fullname.
   */
  public function handleAutocomplete() {
    $matches = [];
    $input = $this->requestStack->getCurrentRequest()->query->get('q');

    $arr_leads = $this->database->select('lead_data', 'l')
      ->fields('l', ['id', 'full_name', 'email'])
      ->condition('full_name', '%' . $input . '%', 'LIKE')
      ->execute()
      ->fetchAll();

    foreach ($arr_leads as $lead) {
      $matches[] = ['value' => $lead->id, 'label' => $lead->full_name . ' ' . $lead->email];
    }

    return new JsonResponse($matches);
  }

}
