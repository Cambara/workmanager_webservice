<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\User;
use \Hash;
use \JWTAuth;
use \Auth;

class UserService
{
    /**
    * @var JWTAuth
    */
    private $jwtAuth;

    /**
    * @var Auth
    */
    private $auth;

    /**
    * @var UserRepository
    */
    private $dao;

    public function __construct(JWTAuth $jwtAuth, Auth $auth, UserRepository $dao)
    {
        $this->jwtAuth = $jwtAuth;
        $this->auth = $auth;
        $this->dao = $dao;
    }

    /** 
    * @param array $params
    * @return User|array
    */
    public function add($params)
    {
        $params['fk_user_types'] = 1; 
        $user = new User(); 
        $user->fill($params);

        if(!$user->isValid())
            return ['errors' => $user->errors];

        $user->password = Hash::make($params['password']);

        if( $error = $this->dao->add($user) !== true)
            return ['errors' => $error];
        return $user;
    }

    /**
    * @param array $params
    * @return array
    */
    public function login($credentials)
    {
        try{
            if(!$token = $this->jwtAuth::attempt($credentials)){
                return ['code_error' => 401, 'result' => ['error' => 'invalid_credentials']];
            }
        } catch(JWTException $e)
        {
            return ['code_error' => 500, 'result' => ['error' => 'could_not_create_token']];
        }

        return ['result' => ['token' => $token, 'user' => $this->auth::user()->load('type')]];
    }

}