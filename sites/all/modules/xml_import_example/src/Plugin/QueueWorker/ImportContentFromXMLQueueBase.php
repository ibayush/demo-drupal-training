<?php

/**
 * @file
 * Contains Drupal\xml_import_example\Plugin\QueueWorker\ImportContentFromXMLQueueBase
 */

namespace Drupal\xml_import_example\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Queue\SuspendQueueException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

/**
 * Provides base functionality for the Import Content From XML Queue Workers.
 */
abstract class ImportContentFromXMLQueueBase extends QueueWorkerBase implements ContainerFactoryPluginInterface {
  
  // Here we don't use the Dependency Injection, 
  // but the create method and __construct method are necessary to implement
  
  /**
   * {@inheritdoc}
   */
  public function __construct() {}
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static();
  }
  
  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    // Get the content array
    $content = $item->data;
    // Create node from the array
    $this->createContent($content);
  }
  
  /**
   * Create content
   *
   * @return int
   */
  protected function createContent($content) {
    // Create node object from the $content array
    $node = Node::create(array(
      'type'  => 'page',
      'title' => $content['title'],
      'body'  => array(
        'value'  => $content['body'],
        'format' => 'basic_html',
      ),
    ));
    $node->save();
  }
}
