<?php

declare(strict_types=1);

namespace Drupal\wordbook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a wordbook entity type.
 */
interface WordbookInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
