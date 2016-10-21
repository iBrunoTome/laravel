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
	Route::put('client/{id}/update', 'ClientController@update');
	Route::delete('client/{id}', 'ClientController@destroy');

	Route::get('project/{id}/note', 'ProjectNoteController@index');
	Route::post('project/{id}/note', 'ProjectNoteController@store');
	Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
	Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
	Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

	Route::get('project/{id}/task', 'ProjectTaskController@index');
	Route::post('project/{id}/task', 'ProjectTaskController@store');
	Route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
	Route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');
	Route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');

	Route::get('project/{id}/member', 'ProjectMemberController@index');

	Route::get('project', 'ProjectController@index');
	Route::post('project', 'ProjectController@store');
	Route::get('project/{id}', 'ProjectController@show');
	Route::put('project/{id}/update', 'ProjectController@update');
	Route::delete('project/{id}', 'ProjectController@destroy');