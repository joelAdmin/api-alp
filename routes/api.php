<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\passportAuthController;
use App\Http\Controllers\MessageController;
//use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider ithin a group which
| is assigned the "api" middleware group. Enjoy bulding your API!
|
*/

//Broadcast::routes(["prefix" => "api", "middleware" => "auth:api"]);
//Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::get('all', [ChatController::class, 'all']);
Route::post('login', [AuthController::class, 'login']);
//Route::post('login_2', [AuthController::class, 'login_2']);



//Route::get('sendMessage', [MessageController::class, 'sendMessage']);

Route::group(['middleware'=>'auth:api'], function(){
    Route::post('sendMessage', [MessageController::class, 'sendMessage']);
    Route::get('all_2', [ChatController::class, 'all_2']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user/{id}', [AuthController::class, 'show']);
    Route::get('chatsAuthU/{id}', [ChatController::class, 'allAuthU']);
    Route::get('chatsAuthM/{id}', [ChatController::class, 'allAuthM']);
    Route::get('subChatAuthM/{id}', [ChatController::class, 'subAllAuthM']);
    Route::get('getMessage/{id}', [MessageController::class, 'show']);
});
