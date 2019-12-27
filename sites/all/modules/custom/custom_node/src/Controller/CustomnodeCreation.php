<?php
namespace Drupal\custom_node\Controller;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\node\Entity\Node;


/**
 * Class CustomnodeCreation.
 *
 * @package Drupal\custom_node\Controller
 */
class CustomnodeCreation extends ControllerBase {

  /**
   * custom node.
   *
   * @return string
   *   Return custom node string.
   */
  public function content() {
    print_r("ssa"); die();
    $node = Node::create(['type' => 'article']);
  	$node->set('title', 'custom node');
  	$node->set('uid', 1);
  	$node->status = 1;
  	$node->enforceIsNew();
  	$node->save();  
    // $service = \Drupal::service('hello_world.say_hello');
    // $services = $service->sayHello();

    return drupal_set_message("Node with nid" . $node->id() . "saved!\n"); 
  }

}
