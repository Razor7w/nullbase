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
    //return isset($_SESSION['user']);
    $user_session = $this->session->getSession('id_usuario');
    return $user_session;
  }

  public function attempt($email, $password){

    //$user = DAOUser::where('gl_email', $email)->first();
    $user = DAOUser::getData($email);


    if (!$user) {
      return false;
    }

    if (password_verify($password, $user[0]->gl_password)) {
      //file_put_contents('php://stderr', PHP_EOL . print_r($user, TRUE). PHP_EOL, FILE_APPEND);
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
