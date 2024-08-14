<?php

namespace Drupal\validate_entity_form\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks that the submitted value is a unique integer.
 *
 * @Constraint(
 *   id = "UniqueInteger",
 *   label = @Translation("Unique Integer", context = "Validation"),
 *   type = "string"
 * )
 */
class UniqueIntegerConstraint extends Constraint {

  /**
   * The message that will be shown if the value is not unique.
   *
   * @var string
   */
  public $notUnique = '%value is not unique.';

}
