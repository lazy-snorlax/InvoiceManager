<?php

namespace App\Controllers;


class Controller  extends \App\Container
{


    public function fullpath($named, $params = [])
    {
        $url      = "http://" . $_SERVER['HTTP_HOST'] . $this->router->pathFor($named, $params);
        return $url;
    }

    // //that will do pig, that will do
    // public function generateRandomString($length = 10) {
    //     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $charactersLength = strlen($characters);
    //     $randomString = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $randomString .= $characters[rand(0, $charactersLength - 1)];
    //     }
    //     return $randomString;
    // }



    public function getOrderByTypeStr($orderType, $orderNum)
    {
        switch ($orderType) {
            case 'Order':
                return \TblordersQuery::create()->findOneByOrdernum($orderNum);
            case 'Prepaid':
                return  \TblprepaidordersQuery::create()->findOneByPrepordernum($orderNum);
            case 'Prearr':
                return  \TblprearrordersQuery::create()->findOneByPrearrnum($orderNum);
            case 'Quote':
                return   \TblquoteordersQuery::create()->findOneByQuotenum($orderNum);
            default:
                throw new \Exception('Unknown order type: ' . $orderType);
                break;
        }
    }


    public function handleException($response, \Throwable $e, $result = [])
    {
        $result['fullmsg'] =  $e->getMessage() . "\n" . $e->getPrevious();
        $result['msg'] = "Error: " . humanError($e);
        $result['error'] = true;
        unset($result['result']);
        $result['class'] = get_class($e);
        return $response->withJSON($result);
    }


    public function ReponseClassSave($response, $o, $result = [])
    {
        $result['saved'] = !empty($o);
        if (!empty($o)) {
            $result['isnew'] = $o->isNew();
            $result['data'] = $o->toArray();
        }
        return $response->withJSON($result);
    }


    public function ReponseWithMessage($response, $message, $result = [])
    {
        $result['msg'] = $message;
        return $response->withJSON($result);
    }

    //$request is needed to handle flag nummber latere
    public function ReponseForDataTable($response,$request, $data, $result = [])
    {
        $result['data'] = $data;
        return $response->withJSON($result);
    }
    
    public function errorJSON($response, string $msg, $payload = [], $status = 200)
    {
        $payload['error'] = true;
        $payload['msg'] =  $msg;
        return $response->withJson($payload, $status);
    }
    private function doe($e, $d = 0)
    {
        if (!$e) return false;
        if ($d > 2) return 'end';
        $j['class'] = get_class($e);
        $j['line'] = $e->getLine();
        $j['msg'] = $e->getMessage();
        $j['file'] = $e->getFile();
        $j['code'] = $e->getCode();
        $j['previous']  = $this->doe($e->getPrevious(), $d++);
        // if (!$j['previous']) 
        //     $j['trace'] = $e->getTrace();
        
        return $j;
    }
    public function exceptJSON($response, \Throwable $e, $payload = [])
    {
        $payload['e'] =  $this->doe($e);
        return $this->errorJSON($response, $e->getMessage(), $payload, 500);
    }
}

