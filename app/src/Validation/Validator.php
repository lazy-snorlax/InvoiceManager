<?php
namespace App\Validation;
use Base;
use PassQuery;
use AuthQuery;
use PatientQuery;
use StaffQuery;
use StockQuery;
class Validator
{
    protected $errors;

    public function validate($username, $password)
    {
        // $loginCheck = $username == $password;

        // if (!$loginCheck) {
        //     return false;
        // }

        // $_SESSION['user'] = $username;

        // return true;

        
        $validation = !empty( $username) && !empty($password);
        
        if (!$validation) {
            return false;
        }

        
        $login = \TblemployeesQuery::create()->findOneByUsername($username);
        // !d("Validator", $validation, $login);
        
        // !ddd($username, $login);
        if (!$login) {
            return false;
        }
        
        // !ddd("Validator", $login);
        if ($login->verifyPassword($password)) {
            // !ddd($login);
        //     if (!empty($login->getIsadmin())) {
        //         $_SESSION['super'] = true;
        //     }
            $_SESSION['user'] = $username;
        //     // !ddd("validate return true", $_SESSION);
            return true;
        }
        
        $_SESSION['errors'] = $this->errors;
        return false; 
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}
