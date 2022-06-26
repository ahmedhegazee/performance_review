<?php

/**
 * Register Admin routes.
 */

use App\Http\Controllers\API\Admin\ReviewFeedbackController;
use App\Http\Controllers\API\Admin\ReviewRequestController;
use App\Http\Controllers\API\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::apiresource('user', UserController::class);
Route::apiresource('review-request', ReviewRequestController::class);
Route::apiresource('review-feedback', ReviewFeedbackController::class)->except(['destroy']);