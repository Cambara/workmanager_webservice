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

Route::group(['prefix' => '/guest', 'as' => 'guest.'],function(){
    Route::post('/login',['uses' => 'ApiAuth\LoginController@login', 'as' => 'login']);
    Route::post('/signup',['uses' => 'ApiAuth\LoginController@signup', 'as' => 'signup']);
});

Route::group(['middleware' => ['auth.jwt'], 'prefix' => '/business', 'as' => 'business.'],function(){
	Route::group(['middleware' => ['typeuser:admin']],function(){
		Route::post('/',['uses' => 'Business\BusinessController@store', 'as' => 'store']);
		Route::put('/{id}',['uses' => 'Business\BusinessController@update', 'as' => 'store']);
		Route::delete('/{id}',['uses' => 'Business\BusinessController@destroy', 'as' => 'destroy']);
	});

	Route::get('/{limit?}',['uses' => 'Business\BusinessController@index', 'as' => 'index']);
});
