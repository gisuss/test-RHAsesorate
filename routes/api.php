<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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
        Route::get('show/{user}', [App\Http\Controllers\Users\UserController::class, 'show']);
        Route::post('update/{user}', [App\Http\Controllers\Users\UserController::class, 'update']);
    });
    
    Route::group(['prefix' => 'quotes'], function () {
        Route::get('favs/{user}', [App\Http\Controllers\Quotes\QuoteController::class, 'getFavQuotes']);
        Route::post('store', [App\Http\Controllers\Quotes\QuoteController::class, 'storeFavQuotes']);
        Route::post('delete/{quote}', [App\Http\Controllers\Quotes\QuoteController::class, 'deleteFavQuotes']);
    });
});
