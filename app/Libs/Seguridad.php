<?php

namespace App\Libs;

class Seguridad{

  public static function generar_sha512($string){
		return hash('sha512',$string);
	}

	public static function generar_sha256($string){
		return hash('sha256',$string);
	}

	public static function generar_sha1($string){
		return hash('sha1',$string);
	}

  /**
   * [passAleatorio description]
   * @return [type] [description]
   */
  public static function randomPass($largo=6){
    $cadena			= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena	= strlen($cadena);
    $pass			= "";
    $longitudPass	= $largo;

    for($i = 1 ; $i <= $longitudPass ; $i++){
      $pos	= rand(0,$longitudCadena-1);
      $pass	.= substr($cadena,$pos,1);
    }

    return $pass;
  }

  /**
	 * [generaTokenUsuario description]
	 * @return [type] [description]
	 */
	public static function generaTokenUsuario($entrada){
		$base       = "Notificacion";
    $random     = Seguridad::randomPass();
		$string     = $base.$random.$entrada;
    $gl_token   = Seguridad::generar_sha512($string);
		return $gl_token;
	}

}
