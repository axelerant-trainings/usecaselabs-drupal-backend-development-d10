<?php

declare(strict_types=1);

namespace Drupal\email_configuration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\EmailValidatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Email configuration settings for this site.
 */
final class EmailConfigForm extends ConfigFormBase {

  /**
   * The email validator service.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * Constructs a UserPasswordForm object.
   *
   * @param \Drupal\Component\Utility\EmailValidatorInterface $email_validator
   *   The email validator service.
   */
  public function __construct(EmailValidatorInterface $email_validator) {
    $this->emailValidator = $email_validator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('email.validator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'email_configuration_email_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['email_configuration.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['template'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Template'),
      '#rows' => 5,
      '#default_value' => $this->config('email_configuration.settings')->get('template'),
      '#description' => $this->t('Enter your email body here.'),
    ];
    $form['email_ids'] = [
      '#type' => 'textarea',
      '#title' => $this->t('User email ids'),
      '#rows' => 5,
      '#default_value' => $this->config('email_configuration.settings')->get('email_ids'),
      '#description' => $this->t('Define users who will receive email notifications eg: test@gmail.com,test2@gmail.com'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $email_ids = $form_state->getValue('email_ids');
    if ($email_ids) {
      $email_ids_array = explode(",", $email_ids);
      if(!empty($email_ids_array)) {
        foreach ($email_ids_array as $email_id) {
          // To validate email id
          if (!$this->emailValidator->isValid($email_id)) {
            $form_state->setErrorByName('email_ids', $this->t('The email ids are not valid.'));
          }
        }
      }
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('email_configuration.settings')
      ->set('template', $form_state->getValue('template'))
      ->set('email_ids', $form_state->getValue('email_ids'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
