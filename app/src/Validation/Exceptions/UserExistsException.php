<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UserExistsException extends ValidationException {

  public static $defaultTemplates = [
    self::MODE_DEFAULT => [
        self::STANDARD => 'Username not found'
    ]

    ];
    
}

