<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    // pages
    Route::namespace('pages')->name('pages.')->group(function () {
        Route::get('dashboard', 'HomeController')->name('dashboard');
    });

    // screencast
    Route::prefix('screencast')->namespace('screencast')->name('screencast.')->group(function () {
        // playlist
        Route::resource('playlists', 'PlaylistController')->middleware(['permission:create-playlists']);
        // tag
        Route::resource('tags', 'TagController');
        // video
        Route::get('/videos/{playlist}/create', 'VideoController@create')->name('videos.create');
        Route::post('/videos/{playlist}/store', 'VideoController@store')->name('videos.store');
        Route::delete('/videos/{video}/{playlist}/destroy', 'VideoController@destroy')->name('videos.destroy');
        Route::get('/videos/{video}/{playlist}/edit', 'VideoController@edit')->name('videos.edit');
        Route::patch('/videos/{video}/{playlist}/update', 'VideoController@update')->name('videos.update');
    });
});


require __DIR__.'/auth.php';
