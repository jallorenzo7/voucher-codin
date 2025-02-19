<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoucherController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vouchers', [VoucherController::class, 'index']);
    Route::post('/vouchers/generate', [VoucherController::class, 'generate']);
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy']);
});