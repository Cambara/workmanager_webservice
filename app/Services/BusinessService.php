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
    /**
    * @param integer $id
    * @return array 
    */
    public function delete($id)
    {
        if(true !== $result = $this->dao->delete($id))
            return ['result' => ['errors' => $result], 'status_code' => 500];
        return ['result' => ['msg' => 'Business removed']];
    }

    public function list($limit)
    {
        if($limit < 1)
            return ['result' => ['errors' => 'Limit is greater than 0'], 'status_code' => 400];

        if(is_string($result = $businesses = $this->dao->list($limit)))
            return ['result' => ['errors' => $result], 'status_code' => 500];
        return ['result' => [$result]];
    }
}