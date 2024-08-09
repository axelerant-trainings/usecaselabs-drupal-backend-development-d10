<?php

declare(strict_types=1);

namespace Drupal\email_configuration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Email configuration settings for this site.
 */
final class EmailConfigForm extends ConfigFormBase {

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
      '#description' => $this->t('Enter your text here.'),
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
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if ($email_ids) {
      $email_ids_array = explode(",", $email_ids);
      if(!empty($email_ids_array)) {
        foreach ($email_ids_array as $email_id) {
          // To validate email id
          if (!preg_match($email_pattern, $email_id)) {
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
