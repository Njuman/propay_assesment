<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Interests
 *
 * @author Cyril.Nxumalo
 */
class InterestsUsers extends Model{
    public $timestamps = false;
    protected $table = 'interests_users';
    
    public function get_interest() {
        return self::get()->first()->toArray();
    }
    
    public function delete_by_user($user_id) {
        self::where('users_id', '=' ,$user_id)->delete();
    }
}
