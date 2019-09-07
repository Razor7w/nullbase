<?php

namespace App\Libs;

use Respect\Validation\Validator as v;
use App\Libs\Uri as uri;

class Load{


  /**
   * Agrega codigo CSS a la vista
   * @param $css
   */
  public static function addCSS($css, $dir = null) {
      if (!filter_var($css, FILTER_VALIDATE_URL) === false) {
          echo '<link type="text/css" href="' . $css . '" rel="stylesheet"/>';
      }else{
          if (!is_null($dir)) {
            // TODO: trabajar con este bloque de codigo
            /*  $dir = trim($dir, DS);
              if (is_file($dir . DS . $css) and is_readable($dir . DS . $css)) {


                  echo '<link href="'. base_url() .$dir . DS . $css.'" type="text/css" rel="stylesheet" />' . "\n";

              } else {
                  self::$js_code .= "\n" . '<script type="text/javascript" charset="' . App::getCharset() . '">' . "\n" . 'console.error("Archivo '.$css.' no se ha cargado");'. "\n" . '</script>' . "\n";
              }*/
          } else {
              $base_url = uri::url();
              $path_url = $base_url . "public/css/" . $css;
              $path = "public/css/" . $css;

              if (file_exists($path)) {
                $val_extension = v::extension('css')->validate($css);

                if($val_extension){
                  echo '<link type="text/css" href="' . $path_url . '" rel="stylesheet"/>';
                }else{
                  echo '<style type="text/css">' . $css . '</style>';
                }
              }else{
                  echo "\n" . '<script type="text/javascript" charset="UTF-8">console.error("[AddCSS] - Archivo '. $css .' no encontrado.");</script>' . "\n";
              }
          }

      }

  }

  /**
   * Agrega codigo Javascript a la vista
   * @param $javascript
   * @param null $dir
   */


  public static function addJS($javascript, $dir = null){

      if (!filter_var($javascript, FILTER_VALIDATE_URL) === false) {
          self::$js_code .= '<script type="text/javascript" src="'.$javascript.'" charset="UTF-8"></script>';
      } else {
          if(!is_null($dir)){
            // TODO: trabajar con este bloque de codigo
              // $dir = trim($dir, DS);
              // if (is_file($dir . DS . $javascript) and is_readable($dir . DS . $javascript)) {
              //     $js_content = file_get_contents($dir . DS .$javascript);
              //
              //     self::$js_code .= "\n" . '<script type="text/javascript" charset="' . App::getCharset() . '">' . "\n" . $js_content . "\n" . '</script>' . "\n";
              //
              // } else {
              //     self::$js_code .= "\n" . '<script type="text/javascript" charset="' . App::getCharset() . '">' . "\n" . 'console.error("Archivo '.$javascript.' no se ha cargado");'. "\n" . '</script>' . "\n";
              // }
          }else{
              $base_url = uri::url();
              $path_url = $base_url . "public/js/" . $javascript;
              $path = "public/js/" . $javascript;
              if (file_exists($path)) {
                $val_extension = v::extension('js')->validate($javascript);

                if($val_extension){
                  echo '<script type="text/javascript" src="'.$path_url.'" charset="UTF-8"></script>';
                }else{
                  echo "\n" . '<script type="text/javascript" charset="UTF-8">' . $javascript . ';</script>' . "\n";
                }
              }else{
                echo "\n" . '<script type="text/javascript" charset="UTF-8">console.error("[AddJS] - Archivo '. $javascript .' no encontrado.");</script>' . "\n";
              }

          }
      }

  }


}
