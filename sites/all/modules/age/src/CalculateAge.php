<?php
/**
* @file providing the service that say age and age 'given name'.
*
*/
namespace  Drupal\age;
class CalculateAge {
 protected $age;
 public function __construct() {
   $this->age = '';
 }
 
 public function calAge($dob){
     $today = date('Y-m-d');
     $this->age = date_diff(date_create($dob), date_create($today)); 
     $age = $this->age;     
     return $age;
 }
}
