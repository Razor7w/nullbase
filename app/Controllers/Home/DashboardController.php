<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;
use App\Models\DAOUser;
use App\Auth\Auth as auth;

class DashboardController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/panel/dashboard.html');
  }
  //Usuario//
  public function getMantenedorUsuarios($request, $response){
    $user = DAOUser::where('bo_activo', '1')->get();
    //file_put_contents('php://stderr', PHP_EOL . print_r($user, TRUE). PHP_EOL, FILE_APPEND);
    $this->view->getEnvironment()->addGlobal('arrays', $user);

    $this->load->addJS("home/mantenedorUsuarios.js");
    return $this->view->render($response, 'templates/panel/mantenedorUsuarios.html');
  }
  public function getAgregarUsuarios($request, $response){
    return $this->view->render($response, 'templates/panel/usuarios/agregar.html');
  }
  public function getInfoUsuarios($request, $response){
    $params = $request->getParams();
    file_put_contents('php://stderr', PHP_EOL . print_r($params, TRUE). PHP_EOL, FILE_APPEND);
    return $this->view->render($response, 'templates/panel/usuarios/info.html');
  }
  public function getEditarUsuarios($request, $response){
    return $this->view->render($response, 'templates/panel/usuarios/editar.html');
  }
  public function getMantenedorProductos($request, $response){
    return $this->view->render($response, 'templates/panel/mantenedorProductos.html');
  }
  public function getPerfil($request, $response){
    return $this->view->render($response, 'templates/panel/perfil.html');
  }
}
