<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class MemStateException extends ValidationException {

  public static $defaultTemplates = [
    self::MODE_DEFAULT => [
        self::STANDARD => 'Select the State!'
    ]

    ];
    
}

