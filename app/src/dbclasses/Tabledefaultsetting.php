<?php

use Base\Tabledefaultsetting as BaseTabledefaultsetting;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the '[Table Default Setting]' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Tabledefaultsetting extends BaseTabledefaultsetting
{
    
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME) {
        // !ddd($this->dateConvert($arr['DateMonthEnd']), $arr);

        if (isset($arr['DateMonthStart'])) {
            if (str_contains($arr['DateMonthStart'], '/')){
                $arr['DateMonthStart'] = $this->dateConvert($arr['DateMonthStart']);
            }
        }
        if (isset($arr['DateMonthEnd'])) {
            if (str_contains($arr['DateMonthEnd'], '/')){
                $arr['DateMonthEnd'] = $this->dateConvert($arr['DateMonthEnd']);
            }
        }
        if (isset($arr['DateYearStart'])) {
            if (str_contains($arr['DateYearStart'], '/')){
                $arr['DateYearStart'] = $this->dateConvert($arr['DateYearStart']);
            }
        }
        if (isset($arr['DateYearEnd'])) {
            if (str_contains($arr['DateYearEnd'], '/')){
                $arr['DateYearEnd'] = $this->dateConvert($arr['DateYearEnd']);
            }
        }

        return parent::fromArray($arr, $keyType);
    }

    public function dateConvert($date) {
        $date = str_replace('/','-',  $date);
        $date = new DateTime($date);
        return $date;
    }

}
