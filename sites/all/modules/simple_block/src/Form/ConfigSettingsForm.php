<?php

namespace Drupal\simple_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\core\Form\FormStateInterface;

//define("MAX_PAGE_LENGTH", 25);

/**
 * Configuration settings form.
 */
class ConfigSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'simple_block.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    //$config = \Drupal::service('config.factory')->getEditable('example.settings');
    //$config->set('message', 'Hioo')->save();

    // Now will print 'Hi'.
    //print_r($config->get('message')); die();
 
    
    //print_r($config); die();
    $config = $this->config('simple_block.settings');
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('email'),
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#default_value' => $config->get('message'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $message = $form_state->getValue('message');
    // if (!empty($email)) {
    //   if (filter_var($limit, FILTER_VALIDATE_INT) === FALSE) {
    //     $form_state->setErrorByName('page_limit', t('Page limit must be an integer'));
    //   }
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config('simple_block.settings')
      // Set the submitted configuration setting.
      ->set('email', $form_state->getValue('email'))
      ->set('message', $form_state->getValue('message'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
