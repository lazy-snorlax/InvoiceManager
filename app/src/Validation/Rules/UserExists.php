<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class UserExists extends AbstractRule {

    public function validate($input) {  		
		 if(null !== \SalespersonsQuery::create()->findOneByUsername($input))
		    return 1;		 
    }
}