<?php

namespace Drupal\entity_update_emails\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\entity_update_emails\MailQueueService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A Queue Worker for processing email sending.
 *
 * @QueueWorker(
 *   id = "email_queue_worker",
 *   title = @Translation("Email Queue Worker"),
 *   cron = {"time" = 60}
 * )
 */
class EmailQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected MailQueueService $mailQueueService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_update_emails.mail_queue_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $this->mailQueueService->sendEmail($data['to'], $data['subject'], $data['body'], $data['params']);
  }

}
