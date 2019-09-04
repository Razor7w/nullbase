<?php

namespace App\Controllers\Auth;

use App\Models\DAOUser;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

  public function getSingUp($request, $response){
    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response){

    $validation = $this->validator->validate($request, [
      'email'    => v::noWhitespace()->notEmpty()->email(),
      'name'     => v::notEmpty()->alpha(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }

    DAOUser::create([
      'gl_email'    => $request->getParam('email'),
      'gl_nick'     => $request->getParam('name'),
      'gl_password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
    ]);

      return $response->withRedirect($this->router->pathFor('home'));
  }
}
