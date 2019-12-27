<?php

namespace Drupal\age\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
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
class AgeDefaultFormatter extends FormatterBase {

  /**
   * Define how the field type is showed.
   * 
   * Inside this method we can customize how the field is displayed inside 
   * pages.
   */
   //$a = format_date("l d M, Y"); 
   //die();
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $today = date('Y-m-d');
    $elements = [];
    foreach ($items as $delta => $item) {
      $age = date_diff(date_create($item->dob), date_create($today)); //print_r($age); die();
      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => $age->format('%y')
      ];
    }

    return $elements;
  }
  
} // class
