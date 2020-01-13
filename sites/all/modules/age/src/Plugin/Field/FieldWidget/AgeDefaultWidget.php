<?php

namespace Drupal\age\Plugin\Field\FieldWidget;

use Drupal;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'AgeDefaultWidget' widget.
 *
 * @FieldWidget(
 *   id = "AgeDefaultWidget",
 *   label = @Translation("Age select"),
 *   field_types = {
 *     "Age"
 *   }
 * )
 */
class AgeDefaultWidget extends WidgetBase {

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

    $element['dob'] = [
      '#type' => 'date',
      '#title' => 'Enter Your Date of Birth',
      '#required' => TRUE,
      '#default_value' => array('month' => 9, 'day' => 6, 'year' => 1962),
      '#format' => 'm/d/Y',
      '#description' => t('i.e. 09/06/2016'),

      // Set here the current value for this field, or a default value (or 
      // null) if there is no a value
      ];

    // City

   

    return $element;
  }

} // class
