<?php

namespace App\Controllers\Home;
use App\Controllers\Controller;

use App\Auth\Auth as auth;

class DashboardController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/panel/dashboard.html');
  }
  public function getMantenedorUsuarios($request, $response){
    return $this->view->render($response, 'templates/panel/mantenedorUsuarios.html');
  }
  public function getMantenedorProductos($request, $response){
    return $this->view->render($response, 'templates/panel/mantenedorProductos.html');
  }
  public function getPerfil($request, $response){
    return $this->view->render($response, 'templates/panel/perfil.html');
  }
}
