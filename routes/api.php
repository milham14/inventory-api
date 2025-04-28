<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;


// Api Role
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('{id}', [RoleController::class, 'show']);
    Route::put('{id}', [RoleController::class, 'update']);
    Route::delete('{id}', [RoleController::class, 'destroy']);
});

// Api Permission
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('{id}', [PermissionController::class, 'show']);
    Route::put('{id}', [PermissionController::class, 'update']);
    Route::delete('{id}', [PermissionController::class, 'destroy']);
});


// Add this route to handle fetching users
//Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']);

// Api Ping
Route::get('/ping', function () {
    return response()->json(['message' => 'Berhasil Tersambung']);
});

// Route tanpa autentikasi
Route::post('/login', [AuthController::class, 'login']);

// Route yang butuh autentikasi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('users', [UserController::class, 'getUsers']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/{id}/role', [UserController::class, 'updateRole']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
