<?php

class SimpleForm extends FormBase {

  public function getFormId() {
    return 'simple_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $placeholder = NULL) {

    $form['name'] = [
      '#title' => $this->t('Name'),
      '#type' => 'textfield',
      '#maxlength' => 64,
      '#size' => 64,
    ];

    $form['message'] = [
      '#title' => $this->t('Message'),
      '#type' => 'textarea',
      '#rows' => 5,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }    
}
