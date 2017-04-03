<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use \Validator;

class Business extends Model
{
	/**
	* @var array
	*/
    protected $fillable = ['company_name', 'cnpj', 'nickname'];

    public function isValid()
    {
        $validator = Validator::make($this->attributes,[
            'cnpj' => [
                'required',
                'cnpj',
                 Rule::unique('businesses')->ignore($this->id)
            ],
            'company_name' => 'required|min:3|max:255',
            'nickname' => 'required|min:5|max:20'
        ]);

        $isFails = $validator->fails();
        
        if($isFails)
        {
            $this->errors = $validator->errors();
        }
        return !$isFails;
    }
}
