<?php

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

Route::middleware('auth:api')->get('/user', 'UserController@getCurrentUser');

Route::get('position', 'ManagePositionsController@list');
Route::get('positionlist', 'ManagePositionsController@datos');
Route::get('userlist/{business_id}', 'ManageUserController@getUsersDatos');
