<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule {

    protected $password;

    public function  __construct($password) {
        $this->userpword = $password;
    }


    public function validate($input) {
         
		  $current = $this->userpword;

        if (\password_verify($input, $current)) {
           // $this->setLastlogin(new \DateTime());
           // $this->save();
            return true;
        }

        return false;
		 
		 
        


    }
}