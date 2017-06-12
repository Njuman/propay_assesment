<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
class Users extends Model {

    public $timestamps = false;
    protected $table = 'users';
    
    public function languages() {
        return $this->hasOne('App\Model\Languages','id','language');
    }
    
    public function interests() {
        return $this->belongsToMany('App\Model\Interests');
    }
}
