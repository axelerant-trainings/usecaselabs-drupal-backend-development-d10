<?php

namespace Drupal\lazy_builder_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Date and Time' block.
 *
 * @Block(
 * id = "date_and_time",
 * admin_label = @Translation("Lazy Builder Date and Time"),
 * category = @Translation("Custom")
 * )
 */
class DateAndTime extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['timestamp'] = [
      '#lazy_builder' => ['lazy_builder_block.timestamp_generator:generateDateAndTime', []],
      '#create_placeholder' => TRUE,
    ];
    $build['#markup'] = $this->t('The current Date and Time is');
    return $build;
  }

}
