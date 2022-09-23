<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\Api')->group(function () {

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('ads', AdController::class);

    Route::get('ads/user/{user}', ['App\Http\Controllers\Api\AdController', 'showUserAds']);

});
