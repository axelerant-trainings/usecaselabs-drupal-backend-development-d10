<?php

namespace Drupal\colourpicker\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Adds a new field type: colourpicker_hex.
 *
 * @FieldType(
 *   id = "colourpicker_hex",
 *   label = @Translation("Colourpicker HEX"),
 *   description = @Translation("Field to store HEX color value."),
 *   default_widget = "colourpicker_hex_widget",
 *   default_formatter = "colourpicker_hex_formatter",
 * )
 */
class ColourPickerHex extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      // Columns contains the values that the field will store.
      'columns' => [
        // List the values that the field will save.
        // This field will only save a single value, 'value'.
        'value' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];

    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('HEX value'));

    return $properties;
  }

}
