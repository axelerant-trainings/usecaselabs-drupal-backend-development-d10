<?php

/**
 * @file
 * This script is only to set the last access time of users.
 *
 * You can run it anyway you want to, I used Devel to do so.
 */

/**
 * Get users.
 */
function getUsers() {
  return \Drupal::entityTypeManager()->getStorage('user')->getQuery()
    ->accessCheck(FALSE)
    ->condition('uid', 0, '>')
    ->condition('status', 1)
    ->execute();
}

/**
 * Update access time to last month.
 */
function updateAccessTimeToLastMonth($uid) {
  $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
  $user->set('access', strtotime('-1month'));
  $user->save();
}

/**
 * Update access time to last year.
 */
function updateAccessTimeToLastYear($uid) {
  $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
  $user->set('access', strtotime('-1year'));
  $user->save();
}

$all_users = getUsers();

foreach (array_values($all_users) as $key => $uid) {
  // Breaking into half to set the access time.
  if ($key <= count($all_users) / 2) {
    updateAccessTimeToLastMonth($uid);
  }
  else {
    updateAccessTimeToLastYear($uid);
  }
}
