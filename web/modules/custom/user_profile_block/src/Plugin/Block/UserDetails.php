<?php

namespace Drupal\user_profile_block\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a "Today's Weather" Block.
 */
#[Block(
  id: "user_profile_details",
  admin_label: new TranslatableMarkup("User Details"),
  category: new TranslatableMarkup("Custom")
)]
class UserDetails extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity type manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $account, EntityTypeManagerInterface $entity_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->currentUser = $account;
    $this->entityTypeManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    // Get the current user object.
    $user_object = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#default_value' => $user_object->get('field_first_name')->value,
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#default_value' => $user_object->get('field_last_name')->value,
      '#required' => TRUE,
    ];

    $form['contact_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Contact Number'),
      '#default_value' => $user_object->get('field_contact_number')->value,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $contact_number = $form_state->getValue('contact_number');
    if (!empty($contact_number) && !is_numeric($contact_number)) {
      $form_state->setErrorByName('contact_number', $this->t('Please enter a valid contact number'));
    }
    if (!empty($contact_number) && strlen($contact_number) !== 10) {
      $form_state->setErrorByName('contact_number', $this->t('Please enter a 10 digit contact number'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Get the form submitted values.
    $form_submitted_values = $form_state->getValues();

    // Update the user name and email as per the values submitted.
    $user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    $user->set('field_first_name', $form_submitted_values['first_name']);
    $user->set('field_last_name', $form_submitted_values['last_name']);
    $user->set('field_contact_number', $form_submitted_values['contact_number']);
    $user->enforceIsNew(FALSE);
    $user->save();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user_object = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());

    return [
      '#theme' => 'user_details',
      '#first_name' => $user_object->get('field_first_name')->value,
      '#last_name' => $user_object->get('field_last_name')->value,
      '#contact_number' => $user_object->get('field_contact_number')->value,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    // Make the block rebuild on user update.
    return Cache::mergeTags(parent::getCacheTags(), ['user:' . $this->currentUser->id()]);
  }

}
