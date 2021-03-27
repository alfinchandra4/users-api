<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('store', [UserController::class, 'store']);
    Route::patch('update/{user_id}', [UserController::class, 'update']);
    Route::delete('delete/{user_id}', [UserController::class, 'delete']);
    Route::get('users', [UserController::class, 'show']);
});
