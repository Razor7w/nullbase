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

    if (password_verify($password, $user[0]->gl_password)) {
      $this->session->setSession('id_usuario', $user[0]->id);
      $this->session->setSession('gl_nombre', $user[0]->gl_nombre);
      $this->session->setSession('id_perfil', $user[0]->id_perfil);
      $this->session->setSession('gl_nombre_perfil', $user[0]->gl_nombre_perfil);
      $this->session->setSession('id_usuario_perfil', $user[0]->id_usuario_perfil);
      return true;
    }

    return false;
  }

  public function logout(){

    $this->session->sessionKill();

  }
}
