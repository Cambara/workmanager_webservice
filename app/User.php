<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
use \Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fk_user_types'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','fk_user_types'
    ];


    public function type()
    {
        return $this->belongsTo('App\UserType', 'fk_user_types', 'id');
    }

    public function isValid()
    {
        $validator = Validator::make($this->attributes,[
            'email' => [
                'required',
                'max:255',
                'email',
                 Rule::unique('users')->ignore($this->id)
            ],
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:5|max:20'
        ]);

        $isFails = $validator->fails();
        
        if($isFails)
        {
            $this->errors = $validator->errors();
        }

        return !$isFails;
    }

}
