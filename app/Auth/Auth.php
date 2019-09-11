<?php

namespace App\Auth;

use App\Models\DAOUser;
use Illuminate\Database\Capsule\Manager as DB;

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
    $user2 = DB::table('usuario')
                ->join('usuario_perfil', 'usuario.id', '=', 'usuario_perfil.id_usuario')
                ->join('perfil'        , 'usuario_perfil.id_perfil', '=', 'perfil.id_perfil')
                ->select('usuario.*', 'usuario_perfil.*', 'perfil.*')
                ->where('gl_email', $email)->get();


    if (!$user) {
      return false;
    }

    if (password_verify($password, $user->gl_password)) {
      file_put_contents('php://stderr', PHP_EOL . print_r($user2, TRUE). PHP_EOL, FILE_APPEND);
      $_SESSION['user'] = $user->id;
      return true;
    }

    return false;
  }

  public function logout(){
    unset($_SESSION['user']);
    unset($_SESSION['csrf']);
    unset($_SESSION['old']);
    //unset($_SESSION['slimFlash']);
    unset($_SESSION['errors']);
  }
}
