<?php

namespace App\Repositories;

use App\WorkTable;

class WorkTableRepository
{
    /**
    * @var WorkTable $dao
    */
    private $dao;
    public function __construct(WorkTable $dao)
    {
        $this->dao = $dao;
    }

    /**
    * @param array $params
    * @return bool|string
    */
    public function add(WorkTable $workTable)
    {
        try{
            return $workTable->save();
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
        $workTable = $this->dao->find($id);
        if(!$workTable) return "worktable not found";

        $workTable->fill($params);

        try{
            return $workTable->save();
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
        $workTable = $this->dao->find($id);
        if(!$workTable) return "worktable not found";

        try{
            return $workTable->delete();
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
            return $e->getMessage();
        }
    }

    public function find($id)
    {
        try{
            return $this->dao->with(['user','business'])->find($id);
        }catch(\Exception $e){
            return $e->getMessage();
        }    
    }
}