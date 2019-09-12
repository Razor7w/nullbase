<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class DAOUser extends Model{
  protected $table = 'usuario';

  protected $fillable = [
    'gl_nombre',
    'gl_email',
    'gl_password'
  ];

  public function setPassword($password){
    $this->update([
      'gl_password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
  }

  public function getData($email){
    $user = DB::table('usuario')
                ->join('usuario_perfil', 'usuario.id', '=', 'usuario_perfil.id_usuario')
                ->join('perfil'        , 'usuario_perfil.id_perfil', '=', 'perfil.id_perfil')
                ->select('usuario.*', 'usuario_perfil.*', 'perfil.*')
                ->where([
                  ['gl_email', $email],
                  ['usuario_perfil.bo_activo', '=', '1']
                ])->get();
                //->where('gl_email', $email)


    return $user;
  }
}
