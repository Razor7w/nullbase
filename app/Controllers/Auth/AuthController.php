<?php

namespace App\Controllers\Auth;

use App\Models\DAOUser;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

  public function getSignOut($request, $response){
    $this->auth->logout();
    return $response->withRedirect($this->router->pathFor('home'));
  }

  // public function getSignIn($request, $response){
  //   return $this->view->render($response, 'auth/signin.twig');
  // }
  public function postSignIn($request, $response){

    $salida = array("correcto" => true);

    $validation = $this->validator->validate($request, [
      'email'    => v::noWhitespace()->notEmpty()->email(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      $errors = $this->session->getSession('errors');
      $salida = array("correcto" => false,  "errorEmail"    => isset($errors['email'][0]) ? $errors['email'][0] : "" ,
                                            "errorPassword" => isset($errors['password'][0]) ? $errors['password'][0] : ""  );
      //return $response->withRedirect($this->router->pathFor('home'));
    }else{
      $auth = $this->auth->attempt(
        $request->getParam('email'),
        $request->getParam('password')
      );


      if (!$auth) {
        $salida = array("correcto" => false, "mensaje" => 'No se pudo iniciar sesión con esos detalles.');
        //return $response->withRedirect($this->router->pathFor('home'));
      }
    }
    //file_put_contents('php://stderr', PHP_EOL . print_r($_SESSION, TRUE). PHP_EOL, FILE_APPEND);
    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
    //return $response->withRedirect($this->router->pathFor('dashboard'));
  }

  // public function getSignUp($request, $response){
  //   return $this->view->render($response, 'auth/signup.twig');
  // }

  // public function postSignUp($request, $response){
  //
  //   $validation = $this->validator->validate($request, [
  //     'email'    => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
  //     'name'     => v::notEmpty()->alpha(),
  //     'password' => v::noWhitespace()->notEmpty(),
  //   ]);
  //
  //   if($validation->failed()){
  //     return $response->withRedirect($this->router->pathFor('auth.signup'));
  //   }
  //
  //   $user = DAOUser::create([
  //     'gl_email'    => $request->getParam('email'),
  //     'gl_nombre'     => $request->getParam('name'),
  //     'gl_password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
  //   ]);
  //
  //   //$this->flash->addMessage('info', 'You have been signed up!');
  //
  //   $this->auth->attempt($user->gl_email, $request->getParam('password'));
  //
  //   return $response->withRedirect($this->router->pathFor('home'));
  // }
}
