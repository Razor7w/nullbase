<?php

namespace App\Controllers;

class Controller{

  protected $container;

  public function __construct($container){

    $this->container = $container;

  }

  //Magic Method
  public function __get($property){

    if($this->container->{$property}){
        return $this->container->{$property};
    }
  }
}
