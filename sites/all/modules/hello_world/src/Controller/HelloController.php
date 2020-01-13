<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HelloController.
 *
 * @package Drupal\hello_world\Controller
 */
class HelloController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    $service = \Drupal::service('hello_world.say_hello');
    $services = $service->sayHello();
    return [
      '#type' => 'markup',
      '#markup' => $services
    ];
  }

}
