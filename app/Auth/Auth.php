<?php

namespace App\Auth;

use App\Models\DAOUser;

class Auth{

  public function user(){
    if (isset($_SESSION['user'])) {
      return DAOUser::find($_SESSION['user']);
    }
  }
  public function check(){
    return isset($_SESSION['user']);
  }

  public function attempt($email, $password){

    $user = DAOUser::where('gl_email', $email)->first();

    if (!$user) {
      return false;
    }

    if (password_verify($password, $user->gl_password)) {
      $_SESSION['user'] = $user->id;
      return true;
    }

    return false;
  }

  public function logout(){
    unset($_SESSION['user']);
  }
}
