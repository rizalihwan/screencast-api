<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::prefix('playlist')->group(function () {
        Route::get('/', 'PlaylistController@getAllPlaylist');
        Route::get('{playlist_slug}/detail', 'PlaylistController@detailPlaylist');
    });

    Route::prefix('video')->group(function () {
        Route::get('{playlist_slug}/all', 'VideoController@getVideoByPlaylist');
        Route::get('{playlist_slug}/{video_episode}/detail', 'VideoController@detailVideo');
    });
});
