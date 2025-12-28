<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TicketApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login'])
    ->middleware('throttle:5,1');
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::apiResource('tickets', TicketApiController::class);
    });
