<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;
use App\Models\DAOUser;
use App\Models\DAOLocal;
use App\Models\DAOUsuarioPerfil;
use App\Models\DAOPerfil;
use Respect\Validation\Validator as v;

class UsuarioController extends Controller{

  public function index($request, $response){
    $user = DAOUser::where('bo_activo', '1')->get();
    //file_put_contents('php://stderr', PHP_EOL . print_r($user, TRUE). PHP_EOL, FILE_APPEND);
    $this->view->getEnvironment()->addGlobal('arrays', $user);
    $this->view->getEnvironment()->addGlobal('id_usuario', $this->session->getSession('id_usuario'));

    $this->load->addJS("home/mantenedorUsuarios.js");
    return $this->view->render($response, 'templates/panel/mantenedorUsuarios.html');
  }

  public function create($request, $response){
    $locales = DAOLocal::get();
    $perfiles = DAOPerfil::get();

    $this->view->getEnvironment()->addGlobal('locales', $locales);
    $this->view->getEnvironment()->addGlobal('perfiles', $perfiles);
    return $this->view->render($response, 'templates/panel/usuarios/agregar.html');
  }

  public function store($request, $response){
    $params = $request->getParams();
    // $affected = DAOUser::insert([
    //                     ['gl_nombre'   => $params['nombre'],
    //                      'gl_email'    => $params['email'],
    //                      'gl_password' => $params['password'],
    //                      'id_local'    => $params['local'],
    //                     ]
    //             ]);

    $validation = $this->validator->validate($request, [
      'email'        => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
      'nombre'       => v::notEmpty()->alpha(),
      'password'     => v::noWhitespace()->notEmpty(),
      'local'        => v::numeric()->positive(),
      'tipo_usuario' => v::numeric()->positive(),
    ]);

    if($validation->failed()){
      $errors = $this->session->getSession('errors');
      $salida = array("correcto" => false,  "errorEmail"       => isset($errors['email'][0]) ? $errors['email'][0] : "" ,
                                            "errorNombre"      => isset($errors['nombre'][0]) ? $errors['nombre'][0] : "",
                                            "errorPassword"    => isset($errors['password'][0]) ? $errors['password'][0] : "",
                                            "errorLocal"       => isset($errors['local'][0]) ? $errors['local'][0] : "",
                                            "errorTipoUsuario" => isset($errors['tipo_usuario'][0]) ? $errors['tipo_usuario'][0] : "");
    }else{

      $passHash = password_hash($params['password'], PASSWORD_DEFAULT);

      $user = new DAOUser;
      $user->id_perfil   = $params['tipo_usuario'];
      $user->id_local    = $params['local'];
      $user->gl_nombre   = $params['nombre'];
      $user->gl_email    = $params['email'];
      $user->gl_password = $passHash;
      $user->gl_token    = $this->seguridad->generaTokenUsuario($passHash);

      $user->save();

      // $userPerfil = new DAOUsuarioPerfil;
      // $userPerfil->id_usuario   = $user->id;
      // $userPerfil->id_perfil    = $params['tipo_usuario'];
      // $userPerfil->bo_principal = $params['tipo_usuario'];
      // $userPerfil->save();

      $salida = array("correcto" => true);
    }


    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
  }

  public function delete($request, $response){
    //Más que un delete, es un update para no mostrarlo.
    $token = $request->getParam('token');

    $affected = DAOUser::where('gl_token', $token)
                        ->update(['bo_activo' => 0]);
    if ($affected == 1) {
      $salida = array("correcto" => true);
    }else{
      $salida = array("correcto" => false);
    }

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);

  }
  public function update($request, $response){
    $id = $request->getParam('id');
    $user = DAOUser::where('id', $id)->first();
    //file_put_contents('php://stderr', PHP_EOL . print_r($user->gl_nombre, TRUE). PHP_EOL, FILE_APPEND);
    //file_put_contents('php://stderr', PHP_EOL . print_r($user->gl_email, TRUE). PHP_EOL, FILE_APPEND);
    return $this->view->render($response, 'templates/panel/usuarios/editar.html');
  }
}
