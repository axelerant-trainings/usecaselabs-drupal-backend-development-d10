<?php

declare(strict_types=1);

namespace Drupal\wordbook\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for a wordbook entity type.
 */
final class WordbookSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'wordbook_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['settings'] = [
      '#markup' => $this->t('Settings form for a wordbook entity type.'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('The configuration has been updated.'));
  }

}
