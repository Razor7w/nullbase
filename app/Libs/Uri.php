<?php

namespace App\Libs;

class Uri{

  public static function url(){
    return sprintf(
       "%s://%s%s",
       isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
       $_SERVER['SERVER_NAME'],
       $_SERVER['REQUEST_URI']
    );
  }
}
