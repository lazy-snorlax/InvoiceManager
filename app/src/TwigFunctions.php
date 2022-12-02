<?php

namespace App;



use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

use Twig\TwigFunction;


use Slim\App;
use App\Controllers\Controller;
use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;

class TwigFunctions extends AbstractExtension
{

    public function getFilters()
    {
        return array(
            'formatdate'  =>  new TwigFilter('formatdate', [$this, 'formatdate']),
            'lookup'  =>  new TwigFilter('lookup', [$this, 'lookup']),
        );
        
    }
    public function getFunctions()
    {
        return array(
            'checked'  =>  new TwigFunction('checked', [$this, 'checked']),
            'fetch'  =>  new TwigFunction('fetch', [$this, 'fetch']),
        );
    }


    public function formatdate($when, $format = 'l, jS F Y')
    {
        if (empty($when)) return '';
        $d = dateConvert($when);
        return  $d->format($format);
    }

    public function lookup($id, $query)
    {
        //SELECT tblTreatmentTypes.TypeID, tblTreatmentTypes.TypeName FROM tblTreatmentTypes;
       
        $con = Propel::getServiceContainer()->getReadConnection('default');
     
        if (empty($query))
            throw new \Exception('Error in query ' . $query);
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function fetch($query)
    {       
        $con = Propel::getServiceContainer()->getReadConnection('default');
     
        if (empty($query))
            throw new \Exception('Error in query ' . $query);
        $stmt = $con->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function checked($value)
    {
        return (!empty($value)) ? "checked" : '';
    }

    public function getName()
    {
        return 'formatdate';
    }
}
