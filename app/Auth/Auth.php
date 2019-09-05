<?php

namespace App\Auth;

use App\Models\DAOUser;

class Auth{

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
}
