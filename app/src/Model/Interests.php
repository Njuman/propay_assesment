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
class Interests extends Model{
    public $timestamps = false;
    protected $table = 'interests';
    
    public function get_interests() {
        return self::all()->toArray();
    }
    
    public function users() {
        return $this->belongsToMany('App\Model\Users');
    }
}
