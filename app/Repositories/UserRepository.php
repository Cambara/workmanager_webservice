<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
    * @var User $dao
    */
    private $dao;
    public function __construct(User $dao)
    {
        $this->dao = $dao;
    }

    /**
    * @param array $params
    * @return User|string
    */
    public function add(User $user)
    {
        try{
            return $user->save();
        }catch(\Exception $e )
        {
            return $e->getMessage();
        }
    }
}