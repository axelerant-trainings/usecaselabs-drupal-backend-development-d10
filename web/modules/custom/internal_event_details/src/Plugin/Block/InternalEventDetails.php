<?php

namespace Drupal\internal_event_details\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a "Internal Event Details" Block.
 */
#[Block(
  id: "internal_event_details",
  admin_label: new TranslatableMarkup("Internal Event Details"),
  category: new TranslatableMarkup("Custom")
)]
class InternalEventDetails extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    // Hide the block when the end time has passed.
    if ($this->configuration['end_time'] > time()) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#description' => $this->t('Please enter the event message to be shown.'),
      '#default_value' => $this->configuration['message'] ?? '',
      '#required' => TRUE,
    ];
    $form['link'] = [
      '#type' => 'url',
      '#title' => $this->t('Link'),
      '#description' => $this->t('Eg: https://www.google.com.'),
      '#default_value' => $this->configuration['link'] ?? '',
    ];
    $form['end_time'] = [
      '#type' => 'datetime',
      '#title' => $this->t('End Time'),
      '#description' => $this->t('Please select the date and time when this block should stop getting displayed to users.'),
      '#default_value' => !empty($this->configuration['end_time']) ? DrupalDateTime::createFromTimestamp($this->configuration['end_time']) : '',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->configuration['message'] = $values['message'];
    $this->configuration['link'] = $values['link'];
    $this->configuration['end_time'] = $values['end_time']->getTimestamp();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'internal_event_details',
      '#message' => $this->configuration['message'],
      '#link' => $this->configuration['link'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // Making the block cache clear based on end time entered.
    return $this->configuration['end_time'] - time();
  }

}
