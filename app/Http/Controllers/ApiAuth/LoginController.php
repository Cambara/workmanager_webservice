<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\User;

class LoginController extends Controller
{
    /**
    * @var UserService
    */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(Request $request)
    {
        $credentials = $request->only("email","password");         
        $resp = $this->userService->login($credentials);
        if(isset($resp['code_error']))
            return response()->json([$resp['result']], $resp['code_error']);
        return response()->json($resp['result']);
    }

    public function signup(Request $request)
    {
        $user = $this->userService->add($request->only("email","password","name"));
        
        if(!$user instanceof User)
            return response()->json($user,500);

        $resp = $this->userService->login($request->only("email","password"));
        
        if(isset($resp['code_error']))
            return response()->json([$resp['result']], $resp['code_error']);
 
        return response()->json($resp['result']);
    }
}