<?php

namespace Drupal\angle\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal;

/**
 * Plugin implementation of the 'AngleDefaultFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "AngleDefaultFormatter",
 *   label = @Translation("Angle"),
 *   field_types = {
 *     "Angle"
 *   }
 * )
 */
class AngleDefaultFormatter extends FormatterBase {

  /**
   * Define how the field type is showed.
   * 
   * Inside this method we can customize how the field is displayed inside 
   * pages.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    
    $elements = [];
    foreach ($items as $delta => $item) {
       $service = \Drupal::service('simple_block.cal_angle');
       $angle = $service->calAngle($item->hours, $item->minutes);
       /*$h = ($item->hours * 360) / 12 + ($item->minutes * 360) / (12 * 60);

	// find position of minute's hand
       $m = ($item->minutes * 360) / (60);

	// calculate the angle difference
       $angle = abs($h - $m);

	// consider shorter angle and return it
	if ($angle > 180) {
	   $angle = 360 - $angle;
        }*/

      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => $angle
      ];
    }

    return $elements;
  }
  
} // class
