<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Endpoint;

use Slim\Views\Twig;
use \Slim\Flash\Messages;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Endpoint\Endpoint;
use App\Classes\Validator;
use App\Helper\Hash;
use App\Helper\Session;

/**
 * Description of UsersEndpoint
 *
 * @author Cyril.Nxumalo
 */
class AuthEndpoint extends Endpoint {

    private $view;

    private $hash;

    private $session;

    private $auth;

    public function __construct(Twig $view, Messages $flash, Hash $hash, $auth) {
        $this->view = $view;
        $this->hash = $hash;
        $this->session  = new Session();
        $this->auth = $auth;
    }

    public function index(Request $request, Response $response) {
        $this->view->render($response, 'login.twig', [
            'csrf' => [
                'name' => $request->getAttribute('csrf_name'),
                'value' => $request->getAttribute('csrf_value'),
            ],
        ]);

        return $response;
    }

    public function loginAction(Request $request, Response $response) {
        $payload = $request->getParsedBody();

        $identifier = $payload['identifier'];
        $password = $payload['password'];

        $validation = new Validator(new \App\Model\Users);

        $validation->validate([
            'identifier'    => [$identifier, 'required'],
            'password'      => [$password, 'required']
            ]);;

        if($validation->passes()){
            $user = \App\Model\Users::where('username', $identifier)->first();
            if($user && $this->hash->passwordCheck($password, $user->password)){ 
                $this->session->set($this->auth['session'],$user->id);
                $results = $this->render($response, ['success' => true], 200);
            }else{
                $flash = 'Sorry, you couldn\'t be logged in.';            
                $results = $this->render($response, ['success' => false,'errors' => $validation->errors(),'flash' => $flash,'request' => $request], 200);
            }
        } else {
            $results = $this->render($response, [
                'success' => false,
                'errors' => $validation->errors(),
                'request' => $request,
                ], 200);
        }

        return $results;
    }

    public function logoutAction(Request $request, Response $response) {
        $session = new \App\Helper\Session;
        $session::destroy();
        return $response->withRedirect('loginAction');
    }
}
