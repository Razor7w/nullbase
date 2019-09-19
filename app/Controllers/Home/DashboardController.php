<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;
use App\Models\DAOUser;
//use App\Auth\Auth as auth;

class DashboardController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/panel/dashboard.html');
  }
  public function getInfoUsuarios($request, $response){
    $params = $request->getParams();
    //file_put_contents('php://stderr', PHP_EOL . print_r($params, TRUE). PHP_EOL, FILE_APPEND);
    return $this->view->render($response, 'templates/panel/usuarios/info.html');
  }
  public function getMantenedorProductos($request, $response){
    return $this->view->render($response, 'templates/panel/mantenedorProductos.html');
  }
  public function getPerfil($request, $response){
    return $this->view->render($response, 'templates/panel/perfil.html');
  }
}
