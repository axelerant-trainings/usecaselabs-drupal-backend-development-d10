<?php

declare(strict_types=1);

namespace Drupal\welcome_configuration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Welcome configuration settings for this site.
 */
final class WelcomeConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'welcome_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['welcome_configuration.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['template'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Template'),
      '#rows' => 5,
      '#required' => TRUE,
      '#default_value' => $this->config('welcome_configuration.settings')->get('template'),
      '#description' => $this->t('Enter your welcome text here. Available tokens: @username, @lastlogin, @membersince'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('welcome_configuration.settings')
      ->set('template', $form_state->getValue('template'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
