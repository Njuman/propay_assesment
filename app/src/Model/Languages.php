<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
class Languages extends Model {

    public $timestamps = false;
    protected $table = 'languages';
    
    public function get_language() {
    	return self::all()->toArray();
    }
    
    public function users() {
        return $this->belongsTo('App\Model\Users','language','id');
    }
}
