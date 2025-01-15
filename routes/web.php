<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\loginController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [RegisterController::class, 'register']);
