<?php

namespace App\Classes;

use App\Model\Users as UsersModel;

class Users {

    public function __contruct() {}

    public function get_users($columns) {
    	return UsersModel::with('languages','interests')->get($columns);
    }
    
    public function get_user($user_id) {
        return UsersModel::whereid($user_id)->with('interests')->first();
    }

    public function find($user_id) {
    	return UsersModel::whereid($user_id);
    }
    
    public function addinterest($users_id , $interest) {
        UsersModel::find($users_id)->interests()->attach($interest);
    }

    public function save_user($user_collection, $interests) {
        $user = new UsersModel();

        foreach ($user_collection as $key => $value) {
            $user->$key = $value;
        }

        $user->save();

        foreach ($interests as $interest) {
            $user->interests()->attach($interest);
        }
    }

    public function delete_user($user_id) {
        UsersModel::where('id', '=' ,$user_id)->delete();
    }

    public function inputs() {
        $input_var = array(
            array('label'=>'Name','name'=>'name','value'=>''),
            array('label'=>'Surname','name'=>'surname','value'=>''),
            array('label'=>'ID Number','name'=>'id_number','value'=>''),
            array('label'=>'Mobile Number','name'=>'mobile_no','value'=>'')
        );

        return $input_var;
    }
}
