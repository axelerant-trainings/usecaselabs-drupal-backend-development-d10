<?php

namespace Drupal\leads_and_event;

use Drupal\Core\Database\Connection;

/**
 * Common functions.
 *
 * @package Drupal\leads_and_event
 */
class LeadsAndEvent {

  public function __construct(protected Connection $database) {
  }

  /**
   * Update Nid Of LeadData.
   */
  public function updateNidOfLeadData($nid, $field_lead_reference) {

    $this->database->update('lead_data')
      ->fields([
        'nid' => $nid,
      ])
      ->condition('id', $field_lead_reference)
      ->execute();

  }

}
