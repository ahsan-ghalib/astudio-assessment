<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EntityAttributeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeSheetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class);

Route::middleware('auth:api')
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('time-sheet', TimeSheetController::class);
        Route::apiResource('entity-attributes', EntityAttributeController::class);
    });
