<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class DAOPerfil extends Model{
  protected $table = 'perfil';
  protected $primaryKey = 'id_perfil';

  protected $fillable = [
    'gl_nombre_perfil',
  ];
}
