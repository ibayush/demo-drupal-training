<?php

namespace Drupal\xml_import_example\Plugin\QueueWorker;

/**
 * Create node object from the imported XML content
 *
 * @QueueWorker(
 *   id = "import_content_from_xml",
 *   title = @Translation("Import Content From XML"),
 *   cron = {"time" = 60}
 * )
 */
class ImportContentFromXMLQueue extends ImportContentFromXMLQueueBase {}
