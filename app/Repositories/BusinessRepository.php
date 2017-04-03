<?php

namespace App\Repositories;

use App\Business;

class BusinessRepository
{
    /**
    * @var Business $dao
    */
    private $dao;
    public function __construct(Business $dao)
    {
        $this->dao = $dao;
    }

    /**
    * @param array $params
    * @return bool|string
    */
    public function add(Business $business)
    {
        try{
            return $business->save();
        }catch(\Exception $e )
        {
            return $e->getMessage();
        }
    }

    /**
    * @param integer $id
    * @param array $params
    * @return bool | string
    */
    public function update($id, $params)
    {
        $business = $this->dao->find($id);
        if(!$business) return "Business not found";

        $business->fill($params);

        try{
            return $business->save();
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
    * @param integer $id
    * @return bool | string
    */
    public function delete($id)
    {
        $business = $this->dao->find($id);
        if(!$business) return "Business not found";

        try{
            return $business->delete();
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function list($limit)
    {
        try{
            return $this->dao->paginate($limit);
        }catch(\Exception $e){

        }
    }
}