<?php

namespace Drupal\colourpicker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Adds a new field widget: colourpicker_hex_widget.
 *
 * @FieldWidget(
 *   id = "colourpicker_hex_widget",
 *   label = @Translation("Colour Picker"),
 *   field_types = {
 *     "colourpicker_hex"
 *   }
 * )
 */
class ColourPickerHexWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element += [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->value ?? '',
      '#suffix' => '<div class="field--colour-picker"></div>',
      '#attributes' => ['class' => ['edit-field--colour-picker']],
      '#attached' => [
        // Add Farbtastic colour picker and the JavaScript file to trigger it.
        'library' => [
          'colourpicker/picker',
        ],
      ],
    ];

    return ['value' => $element];
  }

}
