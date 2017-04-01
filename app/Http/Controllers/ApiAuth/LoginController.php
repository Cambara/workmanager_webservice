<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use \JWTAuth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only("email","password");         
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch(JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function getLogin()
    {
        if( !$user = JWTAuth::parseToken()->authenticate())
            return response()->json(['error' => 'deu ruim'], 404);
        return response()->json(['msg' => 'logado']);
    }
}