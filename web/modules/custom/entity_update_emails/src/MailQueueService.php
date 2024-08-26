<?php

namespace Drupal\entity_update_emails;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Psr\Log\LoggerInterface;

/**
 * Service to queue mails.
 */
class MailQueueService {

  public function __construct(protected QueueFactory $queueFactory,
   protected MailManagerInterface $mailManager,
   protected RendererInterface $renderer,
   protected LoggerInterface $logger,
   protected AccountProxyInterface $currentUser,
   protected UserRoleService $userRoleService) {
  }

  /**
   * Create mail content and put in a queue.
   */
  public function queueEmail($node) {

    $users = $this->userRoleService->getUsersByRole('content_editor');

    foreach ($users as $user) {

      $url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()], ['absolute' => TRUE]);

      $subject = 'An article with the title ' . $node->getTitle() . ' has been updated by ' . $user->get('name')->value;
      $body = 'Hi ' . $user->get('name')->value . "\n\n";
      $body .= "An article with the title <a href='" . $url->toString() . "'>" . $node->getTitle() . "</a> has been updated by " . $user->get('name')->value;

      $params = [];

      $queue = $this->queueFactory->get('email_queue_worker');
      $item = [
        'to' => $user->getEmail(),
        'subject' => $subject,
        'body' => $body,
        'params' => $params,
      ];
      $queue->createItem($item);
    }
  }

  /**
   * Processes the email queue.
   */
  public function processQueue() {
    $queue = $this->queueFactory->get('email_queue_worker');
    $item = $queue->claimItem();

    if ($item) {
      $mail_params = $item->data;
      $this->sendEmail($mail_params['to'], $mail_params['subject'], $mail_params['body'], $mail_params['params']);
      $queue->deleteItem($item);
    }
  }

  /**
   * Sends the email.
   *
   * @param string $sender_email
   *   The recipient email address.
   * @param string $subject
   *   The subject of the email.
   * @param string $body
   *   The body of the email.
   * @param array $params
   *   Additional parameters for the email.
   */
  public function sendEmail($sender_email, $subject, $body, array $params = []) {
    $module = 'entity_update_emails';
    $key = 'email_queue';
    $langcode = $this->currentUser->getPreferredLangcode();
    $send = TRUE;

    $message = [
      'to' => $sender_email,
      'subject' => $subject,
      'body' => $body,
    ];

    $result = $this->mailManager->mail($module, $key, $sender_email, $langcode, $message, NULL, $send);

    if ($result['result'] !== TRUE) {
      // Log the failure.
      $this->logger->error('Failed to send email to %to with subject %subject.', [
        '%to' => $sender_email,
        '%subject' => $subject,
      ]);
    }
  }

}
