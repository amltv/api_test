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
//UsersController
Route::get('/users', 'UsersController@getUsers');
Route::post('/users', 'UsersController@postUsers');
Route::get('/users/{id}', 'UsersController@getUsersById')->where(['id' => '[0-9]+']);
Route::put('/users/{id}', 'UsersController@putUsersById')->where(['id' => '[0-9]+']);

//GroupsController
/*Route::get('/groups', 'GroupsController@getGroups');
Route::post('/groups', 'GroupsController@postGroups');
Route::put('/groups/{id}', 'GroupsController@putGroupsById')->where(['id' => '[0-9]+']);*/