<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;


// Add this route to handle fetching users
Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']);

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// Route tanpa autentikasi
Route::post('/login', [AuthController::class, 'login']);

// Route yang butuh autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
