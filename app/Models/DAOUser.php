<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DAOUser extends Model{
  protected $table = 'user';

  protected $fillable = [
    'gl_nombres',
    'gl_apellidos',
    'gl_nick',
    'gl_email',
    'gl_password'
  ];

  public function setPassword($password){
    $this->update([
      'gl_password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
  }
}
