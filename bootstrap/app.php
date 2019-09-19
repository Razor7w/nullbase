<?php
//Deshabilitar los warnings de php
//error_reporting(0);

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/app_const.php';

$app = new \Slim\App([
    'settings' => [
      'displayErrorDetails' => true,
      'db' => [
        'driver'    =>  DRIVER,
        'host'      =>  HOST,
        'database'  =>  DATABASE,
        'username'  =>  USERNAME,
        'password'  =>  PASSWORD,
        'charset'   =>  CHARSET,
        'collation' =>  COLLATION,
        'prefix'    =>  PREFIX,
      ],
    ]
]);

$container = $app->getContainer();

$container['session'] = function ($container){
  return new App\Libs\Session;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
  return $capsule;
};
$container['auth'] = function ($container){
  return new \App\Auth\Auth($container);
};
$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
      'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
      $container->router,
      $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth',[
      'check'         => $container->auth->check(),
      'user'          => $container->auth->user(),
      'idPerfil'      => $container->auth->getIdPerfil(),
      'nombrePerfil'  => $container->auth->getNombrePerfil(),
    ]);

    return $view;
};
$container['LoginController'] = function ($container){
  return new \App\Controllers\Auth\LoginController($container);
};
$container['AuthController'] = function ($container){
  return new \App\Controllers\Auth\AuthController($container);
};
$container['DashboardController'] = function ($container){
  return new \App\Controllers\Home\DashboardController($container);
};
$container['UsuarioController'] = function ($container){
  return new \App\Controllers\Home\UsuarioController($container);
};
$container['PasswordController'] = function ($container){
  return new \App\Controllers\Auth\PasswordController($container);
};
$container['validator'] = function ($container){
  return new \App\Validation\Validator($container);
};

//Libs//
$container['load'] = function ($container){
  return new App\Libs\Load;
};
$container['uri'] = function ($container){
  return new App\Libs\Uri;
};
$container['seguridad'] = function ($container){
  return new App\Libs\Seguridad;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
//$app->add(new \App\Middleware\OldInputMiddleware($container));

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
