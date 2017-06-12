<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Endpoint;

use Psr\Http\Message\ResponseInterface as Response;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;
use Vasx\ClassMap;
use App\Classes\SystemManager;
use App\Classes\ReferenceDataFormater;

/**
 * Description of Endpoint
 *
 * @author Cyril.Nxumalo
 */
class Endpoint {
    
    public function render(Response $response, $data, $status_code) {
        return $response->withStatus((int) $status_code)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8')
                        ->withJson($data);
    }
    
    public function initBeanMapper($object, $objectMapper) {
        foreach ($objectMapper as $key => $value) {
            if (method_exists($object , 'set'.$key)) {
                call_user_func_array(array($object, 'set'.$key), array((string)$value));
            }
        }
        
        return $object;
    }
}
