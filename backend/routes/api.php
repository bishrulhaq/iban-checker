<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IbanController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/validate-iban', [IbanController::class, 'validateIban']);
    Route::get('/fetch-validated-iban', [IbanController::class, 'fetchValidatedIban']);
});
