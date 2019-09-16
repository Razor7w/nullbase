<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;
use App\Models\DAOUser;

class UsuarioController extends Controller{

  public function index($request, $response){
    $user = DAOUser::where('bo_activo', '1')->get();
    //file_put_contents('php://stderr', PHP_EOL . print_r($user, TRUE). PHP_EOL, FILE_APPEND);
    $this->view->getEnvironment()->addGlobal('arrays', $user);
    $this->view->getEnvironment()->addGlobal('id_usuario', $_SESSION['toast']['id_usuario']);

    $this->load->addJS("home/mantenedorUsuarios.js");
    return $this->view->render($response, 'templates/panel/mantenedorUsuarios.html');
  }

  public function create($request, $response){
    return $this->view->render($response, 'templates/panel/usuarios/agregar.html');
  }

  public function store($request, $response){

  }

  public function delete($request, $response){
    //Más que un delete, es un update para no mostrarlo.
    $id = $request->getParam('id');

    $affected = DAOUser::where('id', $id)
                        ->update(['bo_activo' => 0]);
    if ($affected == 1) {
      $salida = array("correcto" => true);
    }else{
      $salida = array("correcto" => false);
    }

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);

  }
}
