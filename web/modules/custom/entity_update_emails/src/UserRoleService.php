<?php

namespace Drupal\entity_update_emails;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * User role service to get users having a role.
 */
class UserRoleService {

  /**
   * Constructs a new UserRoleService object.
   */
  public function __construct(protected EntityTypeManagerInterface $entityTypeManager) {
  }

  /**
   * Fetches users with a specific role.
   *
   * @param string $role_id
   *   The machine name of the role.
   *
   * @return \Drupal\user\UserInterface[]
   *   An array of user entities.
   */
  public function getUsersByRole($role_id) {
    $user_storage = $this->entityTypeManager->getStorage('user');
    $query = $user_storage->getQuery();
    $query->accessCheck(FALSE);
    // Only active users.
    $query->condition('status', 1);
    $query->condition('roles', $role_id);
    $user_ids = $query->execute();

    return $user_storage->loadMultiple($user_ids);
  }

}
