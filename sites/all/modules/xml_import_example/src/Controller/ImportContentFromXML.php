<?php
/**
 * @file
 * Contains \Drupal\xml_import_example\Controller\ImportContentFromXML.
 */

namespace Drupal\xml_import_example\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Queue\QueueWorkerManager;
use Drupal\Core\Queue\QueueFactory;

/**
 * You can use this constant to set how many queued items
 * you want to be processed in one batch operation 
 */
define("IMPORT_XML_BATCH_SIZE", 1);

class ImportContentFromXML extends ControllerBase {
  
  /**
   * We add QueueFactory and QueueWorkerManager services with the Dependency Injection solution
   */
   
  /**
   * @var QueueFactory
   */
  protected $queueFactory;

  /**
   * @var QueueWorkerManager
   */
  protected $queueManager;
  
  /**
   * {@inheritdoc}
   */
  public function __construct(QueueFactory $queue_factory, QueueWorkerManager $queue_manager) {
    $this->queue_factory = $queue_factory;
    $this->queue_manager = $queue_manager;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $queue_factory = $container->get('queue');
    $queue_manager = $container->get('plugin.manager.queue_worker');
    
    return new static($queue_factory, $queue_manager);
  }
  
  /**
   * Get XML from the API and convert it to 
   */
  protected function getContentsFromXML() {
    // Here you should get the XML content and convert it to an array of content arrays for example
    // I use now an example array of contents:
    $contents = array();
    
    for ($i = 1; $i <= 20; $i++) {
      $contents[] = array(
        'title' => 'Test title ' . $i,
        'body' => 'Test body ' . $i,
      );
    }
    
    // Return with the contents    
    return $contents;
  }
  
  /**
   * Page where the xml source is preprocessed
   */
  public function getContentsFromXMLPage() {
    // Get contents array
    $contents = $this->getContentsFromXML();
    
    foreach ($contents as $content) {
      // Get the queue implementation for import_content_from_xml queue
      $queue = $this->queue_factory->get('import_content_from_xml');
      
      // Create new queue item
      $item = new \stdClass();
      $item->data = $content;
      $queue->createItem($item);
    }
    
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('@count queue items are created.', array('@count' => count($contents))),
    );
  }
  
  /**
   * Process all queue items with batch
   */
  public function processAllQueueItemsWithBatch() {
    
    // Create batch which collects all the specified queue items and process them one after another
    $batch = array(
      'title' => $this->t("Process all XML Import queues with batch"),
      'operations' => array(),
      'finished' => 'Drupal\xml_import_example\Controller\ImportContentFromXML::batchFinished',
    );
    
    // Get the queue implementation for import_content_from_xml queue
    $queue_factory = \Drupal::service('queue');
    $queue = $queue_factory->get('import_content_from_xml');
    
    // Count number of the items in this queue, and create enough batch operations
    for($i = 0; $i < ceil($queue->numberOfItems() / IMPORT_XML_BATCH_SIZE); $i++) {
      // Create batch operations
      $batch['operations'][] = array('Drupal\xml_import_example\Controller\ImportContentFromXML::batchProcess', array());
    }
    
    // Adds the batch sets
    batch_set($batch);
    // Process the batch and after redirect to the frontpage
    return batch_process('<front>');
  }

  /**
   * Common batch processing callback for all operations.
   */
  public static function batchProcess(&$context) {
    
    // We can't use here the Dependency Injection solution
    // so we load the necessary services in the other way
    $queue_factory = \Drupal::service('queue');
    $queue_manager = \Drupal::service('plugin.manager.queue_worker');
    
    // Get the queue implementation for import_content_from_xml queue
    $queue = $queue_factory->get('import_content_from_xml');
    // Get the queue worker
    $queue_worker = $queue_manager->createInstance('import_content_from_xml');
    
    // Get the number of items
    $number_of_queue = ($queue->numberOfItems() < IMPORT_XML_BATCH_SIZE) ? $queue->numberOfItems() : IMPORT_XML_BATCH_SIZE;
    
    // Repeat $number_of_queue times
    for ($i = 0; $i < $number_of_queue; $i++) {
      // Get a queued item
      if ($item = $queue->claimItem()) {
        try {
          // Process it
          $queue_worker->processItem($item->data);
          // If everything was correct, delete the processed item from the queue
          $queue->deleteItem($item);
        }
        catch (SuspendQueueException $e) {
          // If there was an Exception trown because of an error
          // Releases the item that the worker could not process.
          // Another worker can come and process it
          $queue->releaseItem($item);
          break;
        }
      }
    }
  }

  /**
   * Batch finished callback.
   */
  public static function batchFinished($success, $results, $operations) {
    if ($success) {
     drupal_set_message(t("The contents are successfully imported from the XML source."));
    }
    else {
      $error_operation = reset($operations);
      drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
    }
  }
}
