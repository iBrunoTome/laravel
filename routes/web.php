<?php

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| This file is where you may define all of the routes that are handled
	| by your application. Just tell Laravel the URIs it should respond
	| to using a Closure or controller method. Build something great!
	|
	*/

	Route::get('/', function() {
		return view('welcome');
	});

	Route::get('client', 'ClientController@index');
	Route::post('client', 'ClientController@store');
	Route::get('client/{id}', 'ClientController@show');
	Route::delete('client/{id}', 'ClientController@destroy');
	Route::put('client/{id}/update', 'ClientController@update');