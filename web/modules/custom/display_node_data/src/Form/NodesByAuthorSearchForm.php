<?php

namespace Drupal\display_node_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Search form for Nodes by author data.
 */
class NodesByAuthorSearchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_data_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search by Title'),
      '#size' => 30,
      '#maxlength' => 128,
      '#default_value' => $this->getRequest()->query->get('search'),
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
    $data = $form_state->getValue('search');
    $url = Url::fromRoute('display_node_data.display', [], ['query' => ['search' => $data]]);
    $form_state->setRedirectUrl($url);
  }

}
