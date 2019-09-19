<?php

namespace App\Auth;

use App\Models\DAOUser;
use App\Controllers\Controller;

class Auth extends Controller{

  public function user(){
    $user_session = $this->session->getSession('id_usuario');
    if (isset($user_session)) {
      return DAOUser::find($user_session);
    }
  }
  public function check(){
    $user_session = $this->session->getSession('id_usuario');
    return $user_session;
  }
  public function getIdPerfil(){
    $id_perfil = $this->session->getSession('id_perfil');
    return $id_perfil;
  }
  public function getNombrePerfil(){
    $gl_nombre_perfil = $this->session->getSession('gl_nombre_perfil');
    return $gl_nombre_perfil;
  }

  public function attempt($email, $password){

    $getUser = DAOUser::where([
                            ['gl_email', $email],
                            ['bo_activo', '=', '1']
                            ])->first();

    if (!$getUser) {
      return false;
    }

    $user = DAOUser::getData($email);
    //file_put_contents('php://stderr', PHP_EOL . print_r($user, TRUE). PHP_EOL, FILE_APPEND);
    if (password_verify($password, $user->gl_password)) {
      $this->session->setSession('id_usuario', $user->id);
      $this->session->setSession('gl_nombre', $user->gl_nombre);
      $this->session->setSession('id_perfil', $user->id_perfil);
      $this->session->setSession('id_local', $user->id_local);
      $this->session->setSession('gl_nombre_perfil', $user->gl_nombre_perfil);
      $this->session->setSession('gl_nombre_local', $user->gl_nombre_local);
      $this->session->setSession('gl_token', $user->gl_token);
      return true;
    }

    return false;
  }

  public function logout(){

    $this->session->sessionKill();

  }
}
