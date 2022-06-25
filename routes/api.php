<?php

use App\Http\Controllers\API\AuthAPIController;
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


Route::controller(AuthAPIController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'userData');
        Route::post('logout', 'logout');
    });
});