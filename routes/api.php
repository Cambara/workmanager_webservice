<?php

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

Route::group(['middleware' => ['auth.jwt'], 'prefix' => '/worktable', 'as' => 'worktable.'], function(){
	Route::get('/{id}/show/',['uses' => 'WorkTable\WorkTableController@show', 'as' => 'show']);
	Route::get('/{limit?}',['uses' => 'WorkTable\WorkTableController@index', 'as' => 'index']);
	Route::post('/',['uses' => 'WorkTable\WorkTableController@store', 'as' => 'store']);
	Route::put('/{id}',['uses' => 'WorkTable\WorkTableController@update', 'as' => 'update']);
	Route::delete('/{id}',['uses' => 'WorkTable\WorkTableController@destroy', 'as' => 'destroy']);
});