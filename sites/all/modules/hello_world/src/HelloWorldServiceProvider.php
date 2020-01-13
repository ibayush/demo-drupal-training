<?php

namespace Drupal\hello_world;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class HelloWorldServiceProvider.
 *
 * @package Drupal\hello_world
 */
class HelloWorldServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
     $definition = $container->getDefinition('hello_world.say_hello');
     $definition->setClass('Drupal\hello_world\HelloServices2');
  }
}
