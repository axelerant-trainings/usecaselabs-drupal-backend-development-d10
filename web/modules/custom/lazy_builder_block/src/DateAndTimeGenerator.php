<?php

namespace Drupal\lazy_builder_block;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Render\Element\RenderCallbackInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides current date and time as per current loggedin user's timezone.
 *
 * @package Drupal\lazy_builder_block
 */
class DateAndTimeGenerator implements RenderCallbackInterface {

  public function __construct(protected AccountProxyInterface $currentUser) {
  }

  /**
   * Provides current date and time.
   */
  public function generateDateAndTime() {

    // Get user's timezone.
    $timezone = $this->currentUser->getTimeZone();
    $datetime = new DrupalDateTime('now', new \DateTimeZone($timezone));

    return [
      '#markup' => $datetime->format(' d-m-Y H:i:s'),
    ];
  }

}
