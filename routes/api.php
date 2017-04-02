<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.jwt')->get('/user', function (Request $request) {
    return $request->user(); 
});

Route::middleware(['auth.jwt','typeuser:admin'])->get('/my',"ApiAuth\LoginController@getLogin");
Route::post('/login',"ApiAuth\LoginController@login");