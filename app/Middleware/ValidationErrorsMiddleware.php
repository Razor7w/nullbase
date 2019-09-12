<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

      //Evitar warning session no definida
      $errors = $this->session->getSession('errors');
      if(isset($errors)){
        $this->view->getEnvironment()->addGlobal('errors', $errors);
        unset($_SESSION['errors']);
      }
      $response = $next($request, $response);
      return $response;
    }
}
