<?php

use Illuminate\Http\Request;

Route::post('test',function(){
	echo Carbon\Carbon::now();
});


Route::get('login/{email}/{password}','AuthController@login');

Route::get('register/{name}/{email}/{password}','AuthController@register');

Route::post('logout','AuthController@logout');



Route::get('inquiry/{user_id}','ParkController@inquiry');

Route::get('nearest/{user_id}','ParkController@nearest');

Route::post('reserve/{park_id}/{user_id}/{from}/{to}','ParkController@reserve');