<?php

namespace Drupal\leads_and_event\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Lead form for creating and editing Lead.
 */
class LeadForm extends FormBase {

  public function __construct(protected Connection $database) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'add_edit_lead_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {

    $full_name = '';
    $email = '';

    if ($id) {
      $obj_lead = $this->database->select('lead_data', 'l')
        ->fields('l', ['full_name', 'email'])
        ->condition('id', $id)
        ->execute()
        ->fetchObject();

      if ($obj_lead) {
        $full_name = $obj_lead->full_name;
        $email = $obj_lead->email;

        $form['id'] = [
          '#type' => 'hidden',
          '#default_value' => $id,
          '#required' => TRUE,
        ];
      }
      else {
        $url = Url::fromRoute('leads_and_event.add_lead');
        $form_state->setRedirectUrl($url);
      }
    }

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full name'),
      '#size' => 30,
      '#maxlength' => 128,
      '#default_value' => $full_name,
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#size' => 30,
      '#maxlength' => 128,
      '#default_value' => $email,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->database->upsert('lead_data')
      ->key('id')
      ->fields([
        'id' => $form_state->getValue('id'),
        'full_name' => $form_state->getValue('full_name'),
        'email' => $form_state->getValue('email'),
      ])
      ->execute();

    $this->messenger()->addStatus('Lead has been successfully saved.');

  }

}
