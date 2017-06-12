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
use App\Classes\Users;
use App\Classes\Validator;
use App\Helper\Hash;
use App\Model\Languages;
use App\Model\Interests;
use App\Model\InterestsUsers;

/**
 * Description of UsersEndpoint
 *
 * @author Cyril.Nxumalo
 */
class UsersEndpoint extends Endpoint {

    private $view;

    private $flash;

    private $hash;
    
    private $users_model;
    
    private $language_model;
    
    private $interest_model;
    
    private  $interests_users_model;


    public function __construct(Twig $view, Messages $flash, Hash $hash) {
        $this->view = $view;
        $this->flash = $flash;
        $this->hash = $hash;
        $this->users_model = new Users();
        $this->language_model = new Languages();
        $this->interest_model = new Interests();
        $this->interests_users_model = new InterestsUsers();
    }

    public function index(Request $request, Response $response) {
        $columns = array('id','name','surname','id_number','mobile_no','language');
        
        $users = $this->users_model->get_users($columns);
        
    	$this->view->render($response, 'user.twig', [
            'users' => $users
        ]);

    	return $response;
    }

    public function editRender(Request $request, Response $response, $args) {

        $user = $this->users_model->get_user($args['id']);
        
        $input_var = array(
            array('label'=>'Name','name'=>'name','value'=>$user->name),
            array('label'=>'Surname','name'=>'surname','value'=>$user->surname),
            array('label'=>'ID Number','name'=>'id_number','value'=>$user->id_number),
            array('label'=>'Mobile Number','name'=>'mobile_no','value'=>$user->mobile_no)
        );

        $language = $this->language_model->get_language();
        $interests = $this->sort_interest($user->interests->toArray());

        $this->view->render($response, 'edit.twig', [
            'id'=>$args['id'],
            'birth_date'=>$user->birth_date,
            'lang'=>$user->language,
            'input_var' => $input_var,
            'lang_var'  => $language,
            'interest_var' => $this->get_interest_var($interests)
        ]);
        
        return $response;
    }
    
    private function get_interest_var($users_interest = array()) {
        $interest_var = array();
        
        $interests = $this->interest_model->get_interests();
        
        foreach ($interests as $item) {
            $interest_var[] = array(
                'label'=>$item['interest'],
                'value'=>$item['id'],
                'active'=>in_array($item['id'], $users_interest)
            ); 
        }
        
        return $interest_var;
    }
    
    private function sort_interest($users_interests) {
        $interests = array();
        
        foreach ($users_interests as $value) {
            $interests[] = $value['pivot']['interests_id'];
        }
        
        return $interests;
    }

    public function editAction(Request $request, Response $response, $args) {
        $payload = $request->getParsedBody();

        $update = array(
            'name'=>$payload['name'],
            'surname'=>$payload['surname'],
            'id_number'=>$payload['id_number'],
            'mobile_no'=>$payload['mobile_no'],
            'birth_date'=>$payload['birth_date'],
            'language'=>$payload['language']
        );
        
        $this->interests_users_model->delete_by_user($args['id']);
        $this->addinterest($args['id'], (isset($payload['interests'])) ? $payload['interests'] : array());

        $user = $this->users_model->find($args['id']);
        $user->update($update);

        $this->flash->addMessage('success', 'User profile is successfully update');  

        return $response->withStatus(200)->withHeader('Location', '/');
    }
    
    public function addinterest($users_id , $interests) {
        if (!isset($interests) || empty($interests)) {
            return false;
        }

        foreach ($interests as $interest) {
            $this->users_model->addinterest($users_id, $interest); 
        }   
    }

    public function addRender(Request $request, Response $response) {
        $language = $this->language_model->get_language();

        $this->view->render($response, 'add.twig', [
            'input_var' => $this->users_model->inputs(),
            'lang_var'  => $language,
            'interest_var' => $this->get_interest_var()
        ]);
        
        return $response;
    }

    public function addAction(Request $request, Response $response) {
        $payload = $request->getParsedBody();

        $validation = new Validator(new \App\Model\Users);
        
        $validation->validate([
            'name'     => [$payload['name'], 'required'],
            'surname'  => [$payload['surname'], 'required'],
            'username' => [$payload['username'], 'required|uniqueUsername'],
            'id_number'=> [$payload['id_number'], 'required'],
            'mobile_no'  => [$payload['mobile_no'], 'required'],
            'birth_date'  => [$payload['birth_date'], 'required'],
            'password' => [$payload['password'], 'required|min(6)']
        ]);

        if ($validation->passes()) {
            $add = array(
                'name'=>$payload['name'],
                'surname'=>$payload['surname'],
                'username'=>$payload['username'],
                'id_number'=>$payload['id_number'],
                'mobile_no'=>$payload['mobile_no'],
                'birth_date'=>$payload['birth_date'],
                'language'=>$payload['language'],
                'password'=>$this->hash->password($payload['password'])
            );

            $this->users_model->save_user($add, (isset($payload['interests'])) ? $payload['interests'] : array());

            return $response->withStatus(200)->withHeader('Location', '/');

        } else {
            $this->view->render($response, 'add.twig',[
                'errors' => $validation->errors(),
                'input_var' => $this->users_model->inputs(),
                'lang_var'  => $this->language_model->get_language(),
                'interest_var' => $this->get_interest_var(),
                'request' => $request
            ]);
        }

        return $response;
    }

    public function deleteAction(Request $request, Response $response) {
        $payload = $request->getParsedBody();

        foreach ($payload as $id) {
            $this->interests_users_model->delete_by_user($id);
            $this->users_model->delete_user($id);
        }

        $data = array(
            'success'=>true,
            'messages'=>'Users successfully deleted'
            );

        return $this->render($response, $data, 200);
    }
}
