<?php

declare(strict_types=1);

namespace Drupal\user_migrate\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipRowException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Provides an user_validate plugin.
 *
 * Usage:
 *
 * @code
 * process:
 *   sample_field:
 *     plugin: user_validate
 *     source: sample_field_source
 * @endcode
 *
 * @MigrateProcessPlugin(id = "user_validate")
 */
final class UserValidate extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property): mixed {
    // Validate username
    if ($destination_property == 'name') {
      if ($value == "") {
        throw new MigrateSkipRowException("Username can't be empty");
      }
    }

    // Validate email
    if ($destination_property == 'mail') {
      $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
      if ($value == "") {
        throw new MigrateSkipRowException("Email address can't be empty");
      }
      elseif (!preg_match($email_pattern, $value)) {
        throw new MigrateSkipRowException("Email address is invalid");
      }
    }

    // Validate status
    if ($destination_property == 'status') {
      if ($value == "") {
        throw new MigrateSkipRowException("Status can't be empty");
      }
      elseif (!in_array($value, ['0', '1'])) {
        throw new MigrateSkipRowException("Status can only be 0 or 1");
      }
    }

    return $value;
  }

}
