<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvailableException extends ValidationException{

  public static $defaultTemplates = [
      self::MODE_DEFAULT => [
        self::STANDARD => 'El correo electronico ya ha sido tomado.',
      ],
  ];

}
