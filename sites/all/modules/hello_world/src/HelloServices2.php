<?php
/**
* @file providing the service that say hello world and hello 'given name'.
*
*/
namespace  Drupal\hello_world;
class HelloServices2 {
 protected $say_something;
 public function __construct() {
   $this->say_something = 'Hello World jjuu!';
 }
 public function  sayHello($name = ''){
   if (empty($name)) {
     return $this->say_something;
   }
   else {
     return "Hello " . $name . "!";
   }
 }
}
