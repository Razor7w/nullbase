<?php

namespace App\Libs;

use App\Libs\Uri as uri;

class Session{

  public static $session_id = SESSION_ID;

  public static $instance;

  public function __construct(){
      if ( self::is_session_started() === FALSE ) session_start();
      self::$instance = $this;
  }

  private static function is_session_started(){
      if ( php_sapi_name() !== 'cli' ) {
          if ( version_compare(phpversion(), '5.4.0', '>=') ) {
              return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
          } else {
              return session_id() === '' ? FALSE : TRUE;
          }
      }
      return FALSE;
  }

  public static function get(){
      if (self::$instance === null) {
          self::$instance = new self();
      }
      return self::$instance;
  }
  public static function start(){
      if ( self::is_session_started() === FALSE ) session_start();

      $_SESSION[self::$session_id] = array();
  }
  public static function sessionKill($param=null){
      if($param){
          unset($_SESSION[self::$session_id][$param]);
      }else{
          unset($_SESSION[self::$session_id]);
      }
  }
  public static function setSession($param, $value){
      if ( self::is_session_started() === TRUE ){
          self::get();
      }

      $_SESSION[self::$session_id][$param] = $value;
  }
  public static function getSession($param){
      if (isset($_SESSION[self::$session_id][$param])) {
          return $_SESSION[self::$session_id][$param];
      } else {
          return null;
      }
  }
  public static function isValidate(){
      if (!isset($_SESSION[self::$session_id])) {
          $base_url = uri::url();
          header('Location: ' . $base_url);
          die();
      }

  }

}
