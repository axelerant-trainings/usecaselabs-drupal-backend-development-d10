<?php

namespace Drupal\validate_entity_form\Plugin\Validation\Constraint;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the UniqueInteger constraint.
 */
class UniqueIntegerConstraintValidator extends ConstraintValidator implements ContainerInjectionInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a UniqueIntegerConstraintValidator.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function validate($field, Constraint $constraint) {
    $entity = $field->getEntity();

    foreach ($field as $item) {
      if (!$item->value) {
        return;
      }

      // Check if the employee ID value is unique.
      if (!$this->isUnique($entity->id(), $entity->bundle(), $item->value)) {
        // Add violation aka error for not being unique.
        $this->context->addViolation($constraint->notUnique, ['%value' => $item->value]);
      }
    }
  }

  /**
   * Checks if the value provided is unique.
   */
  public function isUnique($id, $type, $value) {
    // Query to check for existing entities with the same field value.
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->accessCheck(FALSE)
      ->condition('type', $type)
      ->condition('field_id', $value);

    if (!empty($id)) {
      $query->condition('nid', $id, '<>');
    }

    $entity_id = $query->range(0, 1)->execute();

    return empty($entity_id) ? TRUE : FALSE;
  }

}
