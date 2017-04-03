<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTable extends Model
{
    /**
    * @var array 
    */
    protected $fiilable = ['fk_business', 'time_begin', 'time_end', 'time_end', 'time_lunch', 'tasks'];

    /**
    * @var array
    */
    protected $hidden = ['fk_business', 'fk_user'];

    public function business()
    {
    	return $this->belongsTo('App\Business','fk_business','id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'fk_user', 'id');
    }
}
