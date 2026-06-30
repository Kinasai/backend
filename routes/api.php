<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JorbiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/jorbi/{route}', [JorbiController::class, 'handler']);
