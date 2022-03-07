<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::prefix('playlist')->group(function () {
        Route::get('/', 'PlaylistController@getAllPlaylist');
        Route::get('{playlist_slug}/detail', 'PlaylistController@detailPlaylist');
    });
});
