<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class DAOUsuarioPerfil extends Model{
  protected $table = 'usuario_perfil';

  protected $fillable = [
    'id_usuario',
    'id_perfil',
    'bo_principal'
  ];
}
