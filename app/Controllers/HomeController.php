<?php

namespace App\Controllers;

use App\Auth\Auth as auth;

class HomeController extends Controller{

  public function index($request, $response){

    $this->load->addJS("home/home.js");

    if(auth::check()){
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    return $this->view->render($response, 'home.html');

  }
}
