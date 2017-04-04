<?php

namespace App\Services;

use App\Repositories\WorkTableRepository; 
use App\WorkTable;
use \Auth;

class WorkTableService
{ 
    /**
    * @var WorkTableRepository
    */
    private $dao;

    /**
    * @var UserRepository
    */
    private $userDao;
    /**
    * @var Auth
    */
    private $auth;

    public function __construct(Auth $auth, WorkTableRepository $dao)
    {
        $this->auth = $auth;
        $this->dao = $dao;
    }

    /** 
    * @param array $params
    * @return array
    */
    public function add($params)
    { 
        $workTable = new WorkTable(); 
        $workTable->fill($params);
        $workTable->fk_user = $this->auth::user()->id;
        if(!$workTable->isValid())
            return ['result' => ['errors' => $workTable->errors], 'status_code' => 400];

        if(true !== $error = $this->dao->add($workTable))
            return ['result' => ['errors' => $error], 'status_code' => 500];
        return ['result' => $workTable ];
    } 

    /**
    * @param integer $id
    * @param array $params
    * @return array
    */
    public function update($id, $params)
    {
        $workTable = new WorkTable();
        $workTable->fill($params);
        $workTable->id = $id; 

        if(!$workTable->isValid())
            return ['result' => ['errors' => $workTable->errors], 'status_code' => 400];
        if(true !== $error = $this->dao->update($id,$params))
            return ['result' => ['errors' => $error], 'status_code' => 500];
        return ['result' => $workTable];
    }
    /**
    * @param integer $id
    * @return array 
    */
    public function delete($id)
    {
        if(true !== $result = $this->dao->delete($id))
            return ['result' => ['errors' => $result], 'status_code' => 500];
        return ['result' => ['msg' => 'WorkTable removed']];
    }

    public function list($limit)
    {
        if($limit < 1)
            return ['result' => ['errors' => 'Limit is greater than 0'], 'status_code' => 400];

        if(is_string($result = $this->dao->list($limit)))
            return ['result' => ['errors' => $result], 'status_code' => 500];
        return ['result' => [$result]];
    }

    public function show($id)
    {
        if(is_string($result = $this->dao->find($id)))
            return ['result' => ['errors' => $result], 'status_code' => 500];
        return ['result' => [$result]];    
    }
}