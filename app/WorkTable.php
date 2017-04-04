<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class WorkTable extends Model
{
    /**
    * @var array 
    */
    protected $fillable = ['fk_business', 'time_begin', 'time_end', 'time_end', 'time_lunch', 'tasks'];

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

    public function isValid()
    {
        $validator = Validator::make($this->attributes,[
            'fk_business' => 'required', 
            'time_begin' => 'required|date_format:"Y-m-d H:i:s"',
            'time_end' => 'required|date_format:"Y-m-d H:i:s"|after:time_begin',
            'time_lunch' => 'required|date_format:"H:i:s"',
            'tasks' => 'required'
        ]);

        $isFails = $validator->fails();
        
        if($isFails)
        {
            $this->errors = $validator->errors();
        }

        return !$isFails;
    }
}
