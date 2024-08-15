<?php

namespace Drupal\block_inactive_users\Controller;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\Controller\ControllerBase;

/**
 * Defines a batch process to block old users.
 */
class BlockUserController extends ControllerBase {

  /**
   * Initiates the batch process to block users.
   */
  public function blockOldUsers() {
    // Get an array of user IDs that need to be blocked.
    $user_ids = $this->getOldUsers();

    // Create a BatchBuilder instance.
    $batch = new BatchBuilder();

    // Set the title of the batch process.
    $batch->setTitle($this->t('Blocking old users'))
      ->setInitMessage($this->t('Starting to block users...'))
      ->setProgressMessage($this->t('Blocked @current out of @total users.'))
      ->setErrorMessage($this->t('An error occurred while blocking users.'));

    // Add the operation to process each user.
    foreach ($user_ids as $user_id) {
      $batch->addOperation(
        [get_class($this), 'blockUser'],
        [$user_id]
      );
    }

    // Specify the finish callback.
    $batch->setFinishCallback([get_class($this), 'batchFinished']);

    // Process the batch.
    batch_set($batch->toArray());

    // Redirect to the batch processing page.
    return batch_process('/admin/people');
  }

  /**
   * Batch operation callback: Block a single user.
   */
  public static function blockUser($user_id, &$context) {
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($user_id);
    if ($user) {
      $user->block()->save();
      $context['message'] = t('Blocked user @name.', ['@name' => $user->getDisplayName()]);
    }
  }

  /**
   * Finish callback for the batch process.
   */
  public static function batchFinished($success, $results, $operations) {
    switch ($success) {
      case TRUE:
        \Drupal::messenger()->addStatus(t('The inactive users are blocked.'));
        break;

      case FALSE:
        \Drupal::messenger()->addError(t('There was an error while processing the request.'));
        break;
    }
  }

  /**
   * Get user IDs who have not logged in for more than 2 months.
   *
   * @return array
   *   An array of user IDs.
   */
  public function getOldUsers() {
    return $this->entityTypeManager()->getStorage('user')->getQuery()
      ->accessCheck(FALSE)
      ->condition('uid', 0, '>')
      ->condition('status', 1)
      ->condition('access', strtotime('-2months midnight'), '<')
      ->execute();
  }

}
