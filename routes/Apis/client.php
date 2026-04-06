<?php

use App\Http\Controllers\Client\AuthController;


Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:client')->get('/me', fn()=>auth()->user());
