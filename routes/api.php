<?php

use App\Http\Controllers\ManagePositionsController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', [UserController::class, 'getCurrentUser']);

Route::get('position', [ManagePositionsController::class, 'list']);
Route::get('positionlist', [ManagePositionsController::class, 'datos']);
Route::get('userlist/{business_id}', [ManageUserController::class, 'getUsersDatos']);
