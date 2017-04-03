<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
	/**
	* @var array
	*/
    protected $fillable = ['company_name', 'cnpj', 'nickname'];
}
