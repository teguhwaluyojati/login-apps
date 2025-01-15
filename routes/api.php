<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\UserUpdateController;
use App\Http\Middleware\CheckTokenExpiration;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', CheckTokenExpiration::class])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => true,
            'user' => $request->user(),
        ]);
    });


    Route::get('/protected-data', function () {
        return response()->json([
            'status' => true,
            'data' => 'This is protected data.',
        ]);
    });
    Route::put('/user/update', [UserUpdateController::class, 'updatePassword']); //api update password
});
