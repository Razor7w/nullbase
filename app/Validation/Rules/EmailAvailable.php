<?php

namespace App\Validation\Rules;

use App\Models\DAOUser;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule {

  public function validate($input){
    return DAOUser::where('gl_email', $input)->count() === 0;
  }
}
