<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'LoginController:index')->setname('home');
//$app->get('/auth/signin', 'AuthController:getSignIn');
$app->post('/auth/signin', 'AuthController:postSignIn')->setName('auth.signin');

$app->group('', function(){
  $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
  $this->post('/auth/signup', 'AuthController:postSignUp');

})->add(new GuestMiddleware($container));

$app->group('', function(){
  $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
  $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
  $this->post('/auth/password/change', 'PasswordController:postChangePassword');

  $this->get('/Dashboard', 'DashboardController:getDashboard')->setName('dashboard');
  $this->get('/Dashboard/MantenedorProductos', 'DashboardController:getMantenedorProductos')->setName('mantenedorProductos');
  $this->get('/Dashboard/Perfil', 'DashboardController:getPerfil')->setName('perfil');


  //Mantenedor Usuarios
  $this->get('/Dashboard/MantenedorUsuarios', 'UsuarioController:index')->setName('mantenedorUsuarios');
  $this->get('/Dashboard/MantenedorUsuarios/Agregar', 'UsuarioController:create')->setName('agregarUsuarios');
  $this->post('/Dashboard/MantenedorUsuarios', 'UsuarioController:store');
  $this->delete('/Dashboard/MantenedorUsuarios', 'UsuarioController:delete');

  $this->get('/Dashboard/MantenedorUsuarios/Info', 'DashboardController:getInfoUsuarios')->setName('infoUsuarios');
  $this->get('/Dashboard/MantenedorUsuarios/Editar', 'DashboardController:getEditarUsuarios')->setName('editarUsuarios');
})->add(new AuthMiddleware($container));
