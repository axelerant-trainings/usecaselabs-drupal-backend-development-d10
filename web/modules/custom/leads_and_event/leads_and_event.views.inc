<?php

/**
 * @file
 * Views integration.
 */

/**
 * Implements hook_views_data().
 */
function leads_and_event_views_data() {

  $data = [];

  $data['lead_data']['table']['group'] = t('Leads and Event');
  $data['lead_data']['table']['base'] = [
    'field' => 'id',
    'title' => t('Leads and Event'),
    'help' => t('Leads Data with reference to Event Node.'),
    'weight' => -10,
  ];
  $data['lead_data']['table']['join'] = [
    'node_field_data' => [
      'left_field' => 'nid',
      'field' => 'nid',
    ],
  ];
  $data['lead_data']['id'] = [
    'title' => t('Lead Id'),
    'help' => t('Lead Id'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'argument' => [
      'id' => 'numeric',
    ],
  ];
  $data['lead_data']['full_name'] = [
    'title' => t('Full Name'),
    'help' => t('Full Name'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],
  ];
  $data['lead_data']['email'] = [
    'title' => t('Email'),
    'help' => t('Email'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],
  ];
  $data['lead_data']['nid'] = [
    'title' => t('Node'),
    'help' => t('Node'),
    'relationship' => [
      'base' => 'node_field_data',
      'base field' => 'nid',
      'id' => 'standard',
      'label' => t('Node'),
    ],
  ];

  return $data;
}
