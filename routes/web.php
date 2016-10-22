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

	use Illuminate\Support\Facades\Response;
	use LucaDegasperi\OAuth2Server\Facades\Authorizer;

	Route::get('/', function() {
		return view('welcome');
	});

	Route::post('oauth/access_token', function() {
		return Response::json(Authorizer::issueAccessToken());
	});

	Route::group(['middleware' => 'oauth'], function() {

		Route::resource('client', 'ClientController', [
			'except' => 'create',
			'edit'
		]);

		Route::group(['prefix' => 'project'], function() {

			Route::resource('project', 'ProjectController', [
				'except' => 'create',
				'edit'
			]);

			Route::get('{id}/note', 'ProjectNoteController@index');
			Route::post('{id}/note', 'ProjectNoteController@store');
			Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
			Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
			Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

			Route::get('{id}/task', 'ProjectTaskController@index');
			Route::post('{id}/task', 'ProjectTaskController@store');
			Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
			Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
			Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');

			Route::get('{id}/member', 'ProjectMemberController@index');
		});
	});

