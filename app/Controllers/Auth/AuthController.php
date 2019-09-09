<?php

namespace App\Controllers\Auth;

use App\Models\DAOUser;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/dashboard.html');
  }
  public function getSignOut($request, $response){
    $this->auth->logout();
    return $response->withRedirect($this->router->pathFor('home'));
  }

  public function getSignIn($request, $response){
    return $this->view->render($response, 'auth/signin.twig');
  }
  public function postSignIn($request, $response){

    $salida = array("correcto" => true, $_SESSION);

    $validation = $this->validator->validate($request, [
      'email'    => v::noWhitespace()->notEmpty()->email(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      // TODO: Mostrar mensajes de los errores
      $salida = array("correcto" => false,  "errorEmail"    => isset($_SESSION['errors']['email'][0]) ? $_SESSION['errors']['email'][0] : "" ,
                                            "errorPassword" => isset($_SESSION['errors']['password'][0]) ? $_SESSION['errors']['password'][0] : ""  );
      //return $response->withRedirect($this->router->pathFor('home'));
    }else{
      $auth = $this->auth->attempt(
        $request->getParam('email'),
        $request->getParam('password')
      );

      if (!$auth) {
        //$this->flash->addMessage('error', 'No se pudo iniciar sesión con esos detalles.');
        $salida = array("correcto" => false, "mensaje" => 'No se pudo iniciar sesión con esos detalles.');
        //return $response->withRedirect($this->router->pathFor('home'));
      }
    }

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
    //return $response->withRedirect($this->router->pathFor('dashboard'));
  }

  public function getSignUp($request, $response){
    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response){

    $validation = $this->validator->validate($request, [
      'email'    => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
      'name'     => v::notEmpty()->alpha(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }

    $user = DAOUser::create([
      'gl_email'    => $request->getParam('email'),
      'gl_nick'     => $request->getParam('name'),
      'gl_password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
    ]);

    $this->flash->addMessage('info', 'You have been signed up!');

    $this->auth->attempt($user->gl_email, $request->getParam('password'));

    return $response->withRedirect($this->router->pathFor('home'));
  }
}
