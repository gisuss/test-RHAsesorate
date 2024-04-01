<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/download/CV_SPA-ENG_Gisuss_03-24.pdf', function () {
    return response()->download(public_path('CV_SPA-ENG_Gisuss_03-24.pdf'));
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\Users\UserController::class, 'store']);
    
    Route::group( ['middleware' => ['auth:sanctum']], function() {
        Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
    });
});

Route::group( ['middleware' => ['auth:sanctum']], function() {
    Route::group(['prefix' => 'user'], function () {
        Route::get('index', [App\Http\Controllers\Users\UserController::class, 'index']);
        Route::get('show/{user}', [App\Http\Controllers\Users\UserController::class, 'show']);
        Route::post('update/{user}', [App\Http\Controllers\Users\UserController::class, 'update']);
        Route::post('activate/{user}', [App\Http\Controllers\Users\UserController::class, 'activarUser']);
        Route::post('desactivate/{user}', [App\Http\Controllers\Users\UserController::class, 'desactivarUser']);
    });
});
