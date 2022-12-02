<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class NewUsernameExistsException extends ValidationException {

  public static $defaultTemplates = [
    self::MODE_DEFAULT => [
        self::STANDARD => 'The Username already exists. Please use a different Username'
    ]

    ];
    
}

