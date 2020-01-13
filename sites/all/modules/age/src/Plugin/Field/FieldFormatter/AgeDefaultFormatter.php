<?php

namespace Drupal\age\Plugin\Field\FieldFormatter;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\age\CalculateAge as Ages;
use Drupal;

/**
 * Plugin implementation of the 'AgeDefaultFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "AgeDefaultFormatter",
 *   label = @Translation("Age"),
 *   field_types = {
 *     "Age"
 *   }
 * )
 */
class AgeDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Define how the field type is showed.
   * 
   * Inside this method we can customize how the field is displayed inside 
   * pages.
   */
   //$a = format_date("l d M, Y"); 
   //die();
  public $calculateAge;
  
   public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      // Add any services you want to inject here
      $container->get('age.cal_age')
    );
  }

  /**
 * Construct a MyFormatter object.
 *
 * @param string $plugin_id
 *   The plugin_id for the plugin instance.
 * @param mixed $plugin_definition
 *   The plugin implementation definition.
 * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
 *   Defines an interface for entity field definitions.
 * @param array $settings
 *   The formatter settings.
 * @param string $label
 *   The formatter label display setting.
 * @param string $view_mode
 *   The view mode.
 * @param array $third_party_settings
 *   Any third party settings.
 * @param Drupal\age\Plugin\Field\FieldType\Age $calculateAge
 *   Entity manager service.
 */

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, Ages $calculateAge) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->calculateAge = $calculateAge;
  }

  public function viewElements(FieldItemListInterface $items, $langcode) { 
    //$today = date('Y-m-d');
    $elements = [];
    foreach ($items as $delta => $item) {
      //$age = date_diff(date_create($item->dob), date_create($today)); //print_r($age); die();
      $age  =$this->calculateAge->calAge($item->dob); 
       $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => $age->format('%y')
      ];
    }

    return $elements;
  }
  
} // class
