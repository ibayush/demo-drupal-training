<?php
/**
* @file providing the service that say angle and angle 'given name'.
*
*/
namespace  Drupal\angle;
class CalculateAngle {
 protected $angle;
 public function __construct() {
   $this->angle = '';
 }
 
 public function calAge($hours, $minutes){
    $h = ($hours * 360) / 12 + ($minutes * 360) / (12 * 60);
    // find position of minute's hand
    $m = ($minutes * 360) / (60);
    // calculate the angle difference
    $this->angle = abs($h - $m);
    $angle = $this->angle;
    // consider shorter angle and return it
    if ($this->angle > 180) {
      $angle = 360 - $this->angle;
    }
    return $angle;
 }
}
