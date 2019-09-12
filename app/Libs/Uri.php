<?php

namespace App\Libs;

class Uri{

  private static $_port;

  public function __construct(){
      self::$_port = '';
      if ($_SERVER['SERVER_PORT'] != 80) {
          self::$_port = ':' . $_SERVER['SERVER_PORT'];
      }
  }

  public static function getHost(){
      self::$_port = '';
      if ($_SERVER['SERVER_PORT'] != 80){
          self::$_port = ':' . $_SERVER['SERVER_PORT'];
      }
      $url = $_SERVER['SERVER_NAME'] . self::$_port . $_SERVER['SCRIPT_NAME'];
      $url = explode('/', $url);
      $tmp = array_pop($url);
      $url = implode("/", $url);

      $httpX = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';

      return $httpX .'://' . $url . '/';

  }

  public static function getBaseUri(){
      self::$_port = '';
      if ($_SERVER['SERVER_PORT'] != 80) {
          self::$_port = ':' . $_SERVER['SERVER_PORT'];
      }
      $url = $_SERVER['SERVER_NAME'] . self::$_port . $_SERVER['SCRIPT_NAME'];
      $httpX = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
      return $httpX.'://' . $url;


  }

  public static function url(){
    return sprintf(
       "%s://%s%s",
       isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
       $_SERVER['SERVER_NAME'],
       $_SERVER['REQUEST_URI']
    );
  }
}
