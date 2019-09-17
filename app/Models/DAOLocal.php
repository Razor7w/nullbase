<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class DAOLocal extends Model{
  protected $table = 'local';

  protected $fillable = [
    'gl_nombre_local'
  ];
}
