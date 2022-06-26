<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\UserReviewFeedbackController;
use App\Http\Controllers\UserReviewRequestController;
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
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('review-feedback', UserReviewFeedbackController::class)
        ->only(['index', 'show']);
    Route::controller(UserReviewRequestController::class)
        ->group(function () {
            Route::get('review-request', 'index');
            Route::post('review-request/{review_request}/write-feedback', 'writeFeedback');
        });
});