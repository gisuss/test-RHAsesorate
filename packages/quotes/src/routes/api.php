<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/quotes'], function () {
    Route::group( ['middleware' => ['auth:sanctum']], function() {
        Route::get('quote/{id}', [Gisuss\Quotes\Controllers\QuoteController::class, 'showQuote']);
        Route::get('random/{lot}', [Gisuss\Quotes\Controllers\QuoteController::class, 'randomQuotes']);
        Route::post('to-fav', [Gisuss\Quotes\Controllers\QuoteController::class, 'toFav']);
        Route::post('to-trash', [Gisuss\Quotes\Controllers\QuoteController::class, 'toTrash']);
        Route::get('fav/{user_id}', [Gisuss\Quotes\Controllers\QuoteController::class, 'favs']);
    });
});
