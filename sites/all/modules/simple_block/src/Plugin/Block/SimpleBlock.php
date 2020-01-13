<?php
/**
 * @file
 * Contains \Drupal\simple_block\Plugin\Block\XaiBlock.
 */
namespace Drupal\simple_block\Plugin\Block;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Simble block' block.
 *
 * @Block(
 *   id = "simple_block",
 *   admin_label = @Translation("Simple block"),
 *   category = @Translation("Custom simple block example")
 * )
 */
class SimpleBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * {@inheritdoc}
   */

  protected $account;
  protected $formBuilder;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $account, FormBuilderInterface $formBuilder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $account;
    $this->formBuilder = $formBuilder;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('form_builder')
    );
  }

  public function build() {
    $build = [];
    //print_r($this->account->id()); die();
    //$form = $this->formBuilder->getForm('Drupal\simple_block\Form\SimpleForm');
    //$build['drupalist_activate_block']['#markup'] = $form;
    $build['drupalist_activate_block']['#markup'] = '<p>Your user id is ' . $uid = $this->account->id() . '</p>';
    return $build;
  }
}
