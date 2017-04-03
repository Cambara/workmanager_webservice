<?php

namespace App\Services;

use App\Repositories\BusinessRepository;
use App\Business;

class BusinessService
{ 
    /**
    * @var BusinessRepository
    */
    private $dao;

    public function __construct(BusinessRepository $dao)
    {
        $this->dao = $dao;
    }

    /** 
    * @param array $params
    * @return array
    */
    public function add($params)
    { 
        $business = new Business(); 
        $business->fill($params);

        if(!$business->isValid())
            return ['result' => ['errors' => $business->errors], 'status_code' => 400];

        if(true !== $error = $this->dao->add($business))
            return ['result' => ['errors' => $error], 'status_code' => 500];
        return ['result' => $business ];
    } 

    /**
    * @param integer $id
    * @param array $params
    * @return array
    */
    public function update($id, $params)
    {
        $business = new Business();
        $business->fill($params);
        $business->id = $id; 

        if(!$business->isValid())
            return ['result' => ['errors' => $business->errors], 'status_code' => 400];
        if(true !== $error = $this->dao->update($id,$params))
            return ['result' => ['errors' => $error], 'status_code' => 500];
        return ['result' => $business];
    }
}