<?php

declare(strict_types=1);

namespace Drupal\welcome_configuration\Controller;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;

/**
 * Returns responses for Welcome.
 */
final class WelcomeController extends ControllerBase {

  /**
   * Welcome controller constructor.
   */
  public function __construct(protected DateFormatterInterface $dateFormatter) {}

  /**
   * Builds the response.
   */
  public function __invoke(): array {
    $template_body = $this->config('welcome_configuration.settings')->get('template') ?? '';
    $user = $this->entityTypeManager()->getStorage('user')->load($this->currentUser()->id());
    $membersince = $this->dateFormatter->format($user->getCreatedTime(), 'custom', 'd-m-Y', $this->currentUser->getTimeZone());
    $lastlogin = $this->dateFormatter->format($this->currentUser->getLastAccessedTime(), 'custom', 'd-m-Y', $this->currentUser->getTimeZone());
    $template_markup = Markup::create(nl2br($template_body));

    return [
      '#type' => 'markup',
      '#markup' => $this->t($template_markup->__toString(), [
        '@username' => $this->currentUser->getDisplayName(),
        '@last-login-date' => $lastlogin,
        '@member-since' => $membersince
      ]),
      '#cache' => [
        'tags' => [
          'config:welcome_configuration.settings'
        ]
      ],
    ];

  }

}
