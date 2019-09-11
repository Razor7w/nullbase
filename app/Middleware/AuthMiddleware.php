<?php

namespace App\Middleware;


class AuthMiddleware extends Middleware{

  public function __invoke($request, $response, $next){

    if (!$this->container->auth->check()) {
      //$this->container->flash->addMessage('error', 'Inicia sesión antes de hacerlo.');
      return $response->withRedirect($this->container->router->pathFor('home'));
    }

    $response = $next($request, $response);
    return $response;
  }
}
