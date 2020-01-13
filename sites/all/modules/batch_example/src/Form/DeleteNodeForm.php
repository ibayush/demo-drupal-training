<?php
namespace Drupal\batch_example\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Class DeleteNodeForm.
 *
 * @package Drupal\batch_example\Form
 */
class DeleteNodeForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_node_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['node_id'] = [
      '#title' => $this->t('Enter Node ID'),
      '#type' => 'textfield',
      '#maxlength' => 64,
      '#size' => 64,
      '#description' => $this->t('Enter the node id with comma separated')
    ];
    
    $form['delete_node'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Delete Node'),
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $input_node_id = $form_state->getValue('node_id');
    $user_nodes = explode(",", $input_node_id);
   if($user_nodes[0] == "") {
    $nids = \Drupal::entityQuery('node')
    ->condition('type', 'article')
    ->sort('created', 'ASC')
    ->execute(); //print_r($nids); die();
   }else {   
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'article')
      ->condition('nid', $user_nodes, 'IN')
      ->sort('created', 'ASC')
      ->execute(); //print_r($nids); die();
   }  
    $batch = array(
      'title' => t('Deleting Node...'),
      'operations' => array(
        array(
          '\Drupal\batch_example\DeleteNode::deleteNodeExample',
          array($nids)
        ),
      ),
      'finished' => '\Drupal\batch_example\DeleteNode::deleteNodeExampleFinishedCallback',
    );
    batch_set($batch);
  }
}
