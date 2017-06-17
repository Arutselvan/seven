<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/data', function () {
    return view('welcome');
});

Route::group(['middleware'=>'login'] , function() {
	Route::get('/register', function () {
    	return view('register');
	});

	Route::get('/login', function () {
    	return view('login');
	});

});



Route::group(['middleware'=>'json'] , function() {

	Route::post('/register','UserReg@register');
	Route::post('/auth','Auth\UserAuth@webAuth');
	Route::group(['middleware'=>'user'] , function() {
		Route::post('/geo','GetRestaurants@geo');
		Route::post('/senti','GetRestaurants@senti');
		Route::get('/logout','Auth\UserAuth@logout');

	});
});
