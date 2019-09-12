<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Auth\Auth as auth;

class LoginController extends Controller{

  public function index($request, $response){

    $this->load->addJS("home/home.js");


    if($this->auth->check()){
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    return $this->view->render($response, 'home.html');

  }
}
