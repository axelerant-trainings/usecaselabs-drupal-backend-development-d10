<?php

declare(strict_types=1);

namespace Drupal\welcome_configuration\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;

/**
 * Returns responses for Welcome.
 */
final class WelcomeController extends ControllerBase {

  /**
   * Welcome controller constructor.
   */
  public function __construct(protected ConfigFactoryInterface $config_factory, protected AccountInterface $account, protected DateFormatterInterface $dateFormatter) {
    $this->config_factory = $config_factory;
    $this->account = $account;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('current_user'),
      $container->get('date.formatter'),
    );
  }
  /**
   * Builds the response.
   */
  public function __invoke(): array {
    $template_body = $this->config_factory->get('welcome_configuration.settings')->get('template') ?? '';
    $user = User::load($this->account->id());
    $membersince = $this->dateFormatter->format($user->getCreatedTime(), 'custom', 'd-m-Y', $this->account->getTimeZone());
    $lastlogin = $this->dateFormatter->format($this->account->getLastAccessedTime(), 'custom', 'd-m-Y H:i', $this->account->getTimeZone());
    $template_markup = Markup::create(nl2br($template_body));

    return [
      '#type' => 'markup',
      '#markup' => $this->t($template_markup->__toString(), [
        '@username' => $this->account->getDisplayName(),
        '@lastlogin' => $lastlogin,
        '@membersince' => $membersince
      ]),
      '#cache' => [
        'max-age' => 0,
      ],
    ];

  }

}
