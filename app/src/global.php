<?php

function ddd(...$v)
{
    d(...$v);
    exit;
}
Kint::$aliases[] = 'ddd';



function dateConvert($before)
{
    if (empty($before)) return null;
    try {
        if (strpos($before, '-')) {
            return  new DateTime($before);
        }

        $alter = str_replace('\\', '/', $before);
        $val = explode('/',  $alter);

        if (sizeof($val) < 2)
            throw new Exception('Invalid date format,' . $before . ' ' . print_r(sizeof($val), true));


        $size = sizeof($val);
        return  new DateTime($val[$size - 1] . '-' . $val[$size - 2] . '-' . $val[$size - 3]);
    } catch (\Throwable $th) {
        throw new Exception('Invalid date format,' . $before . ' ' . $th->getMessage());
    }
}

function timeConvert($before)
{
    $val = explode(':', $before);
    $time = $val[0] . $val[1];
    return $time;
}


function humanError(\Throwable $e)
{
    try {

        if ($e instanceof  \Propel\Runtime\ActiveQuery\QueryExecutor\QueryExecutionException) {
            if ($p = $e->getPrevious()) {
                return humanError($p);              
            }
        }
        if ($e instanceof \PDOException) {
            $msg = $e->getMessage();
            //error info is a cleaner message sometimes
            if (sizeof($e->errorInfo) >= 2) {
                $msg = $e->errorInfo[2];
            }
            $msg = explode(']', $msg);
            return $msg[sizeof($msg)-1];
        }

      
    } catch (\Throwable $th) {
        return $e->getMessage();
    }
    return $e->getMessage();
}
