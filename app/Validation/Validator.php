<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
use App\Controllers\Controller;

class Validator extends Controller{
  protected $errors;
  public function Validate($request, array $rules){

    foreach ($rules as $field => $rule) {
      try{
        $rule->setName(ucfirst($field))->assert($request->getParam($field));
      }catch(NestedValidationException $e){
        $this->errors[$field] = $e->getMessages();
      }
    }

    if ($this->errors) {
      $this->session->setSession('errors', $this->errors);
    }

    return $this;
  }

  public function failed(){
    return !empty($this->errors);
  }
}
