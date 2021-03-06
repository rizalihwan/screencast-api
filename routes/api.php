<?php

use Illuminate\Support\Facades\Route;;

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
    });

    Route::prefix('playlist')->group(function () {
        Route::get('/', 'PlaylistController@getAllPlaylist');
        Route::get('{playlist_slug}/detail', 'PlaylistController@detailPlaylist');
        Route::get('/user', 'PlaylistController@userHavePlaylist')->middleware('auth:sanctum');
    });

    Route::prefix('video')->group(function () {
        Route::get('{playlist_slug}/all', 'VideoController@getVideoByPlaylist');
        Route::get('{playlist_slug}/{video_episode}/detail', 'VideoController@detailVideo')->middleware('auth:sanctum');
    });

    Route::prefix('order')->namespace('Order')->middleware('auth:sanctum')->group(function () {
        Route::post('add', 'OrderController@store');

        Route::prefix('cart')->group(function () {
            Route::get('/', 'CartController@index');
            Route::post('add/{playlist}', 'CartController@addToCart');
        });
    });
});

Route::namespace('Api\V1\Order')->group(function () {
    Route::post('notification-handler', 'OrderController@notificationHandler');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/user', 'UserController');
    });
});
