<?php

namespace Drupal\colourpicker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Adds a new field formatter: colourpicker_hex_formatter.
 *
 * @FieldFormatter(
 *   id = "colourpicker_hex_formatter",
 *   label = @Translation("Colourpicker Text"),
 *   field_types = {
 *     "colourpicker_hex"
 *   }
 * )
 */
class ColourPickerHexFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#markup' => '<p>The colour selected is ' . $item->value . '</p>',
      ];
    }

    return $elements;
  }

}
