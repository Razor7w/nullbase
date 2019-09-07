<?php

namespace App\Controllers\Auth;

use App\Models\DAOUser;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

  public function getDashboard($request, $response){
    return $this->view->render($response, 'templates/dashboard.twig');
  }
  public function getSignOut($request, $response){
    $this->auth->logout();
    return $response->withRedirect($this->router->pathFor('home'));
  }

  public function getSignIn($request, $response){
    return $this->view->render($response, 'auth/signin.twig');
  }
  public function postSignIn($request, $response){

    $validation = $this->validator->validate($request, [
      'email'    => v::noWhitespace()->notEmpty()->email(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->router->pathFor('home'));
    }

    $auth = $this->auth->attempt(
      $request->getParam('email'),
      $request->getParam('password')
    );

    if (!$auth) {
      $this->flash->addMessage('error', 'No se pudo iniciar sesión con esos detalles.');
      return $response->withRedirect($this->router->pathFor('home'));
    }

    return $response->withRedirect($this->router->pathFor('dashboard'));
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
