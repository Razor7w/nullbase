<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class DAOUser extends Model{
  protected $table = 'usuario';

  protected $fillable = [
    'id_perfil',
    'id_local',
    'gl_nombre',
    'gl_email',
    'gl_password',
    'bo_activo',
    'gl_token'
  ];

  public function setPassword($password){
    $this->update([
      'gl_password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
  }

  public function getData($email){
    // $user = DB::table('usuario')
    //             ->join('usuario_perfil', 'usuario.id', '=', 'usuario_perfil.id_usuario')
    //             ->join('perfil'        , 'usuario_perfil.id_perfil', '=', 'perfil.id_perfil')
    //             ->select('usuario.*', 'usuario_perfil.*', 'perfil.*')
    //             ->where([
    //               ['gl_email', $email],
    //               ['usuario_perfil.bo_activo', '=', '1']
    //             ])->get();
    $user = DB::table('usuario')
                ->join('perfil', 'perfil.id_perfil','=','usuario.id_perfil')
                ->join('local', 'local.id', '=', 'usuario.id_local')
                ->select('usuario.*', 'perfil.gl_nombre_perfil', 'local.gl_nombre_local')
                ->where('gl_email', $email)
                ->first();
    return $user;
  }
}
