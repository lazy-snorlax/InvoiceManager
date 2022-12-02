<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class ConfirmPasswordException extends ValidationException {

	public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Confirm Password and Password did not match' // or any message you want
        ]
    ];
    
}

