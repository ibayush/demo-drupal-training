<?php

namespace Drupal\angle\Plugin\Field\FieldWidget;

use Drupal;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'AngleDefaultWidget' widget.
 *
 * @FieldWidget(
 *   id = "AngleDefaultWidget",
 *   label = @Translation("Angle select"),
 *   field_types = {
 *     "Angle"
 *   }
 * )
 */
class AngleDefaultWidget extends WidgetBase {

  /**
   * Define the form for the field type.
   * 
   * Inside this method we can define the form used to edit the field type.
   * 
   * Here there is a list of allowed element types: https://goo.gl/XVd4tA
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta, 
    Array $element, 
    Array &$form, 
    FormStateInterface $formState
  ) {

    // Street

    $element['hours'] = [
      '#type' => 'number',
      '#title' => 'Hours',
      '#required' => TRUE,
      '#description' => t('i.e. 2, 3, 11, 12'),
      ];

    $element['minute'] = [
      '#type' => 'number',
      '#title' => 'Minutes',
      '#required' => TRUE,
      #'#default_value' => array('month' => 9, 'day' => 6, 'year' => 1962),
      '#description' => t('i.e. 1,16, 48'),
      ];


   

    return $element;
  }

} // class
