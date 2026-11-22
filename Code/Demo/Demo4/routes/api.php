<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
});

Route::apiResource('media',MediaController::class) -> parameters([
    'media' => 'media'
]);

Route::prefix('users/{user}/media') -> group(function(){
    Route::get('/',[UserMediaController::class,'index']);
    Route::post('/{media}',[UserMediaController::class,'store']);
    Route::delete('/{media}',[UserMediaController::class,'detach']);
});
