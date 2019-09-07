<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setname('home');
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

  $this->get('/dashboard', 'AuthController:getDashboard')->setName('dashboard');
})->add(new AuthMiddleware($container));
