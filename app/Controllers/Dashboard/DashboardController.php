<?php

namespace App\Controllers\Dashboard;
use App\Controllers\Controller;

use App\Auth\Auth as auth;

class DashboardController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/dashboard.html');
  }
  public function getMantenedorUsuarios($request, $response){
    return $this->view->render($response, 'templates/mantenedorUsuarios.html');
  }
  public function getMantenedorProductos($request, $response){
    return $this->view->render($response, 'templates/mantenedorProductos.html');
  }
}
