<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth:api'
])
    ->name('posts.')
    ->namespace('\App\Http\Controllers')
    ->group(function() {
        Route::get('/posts', "PostController@index")
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/posts/{post}', "PostController@show")
            ->name('show')
            ->whereNumber('post');

        Route::post('posts', "PostController@store")->name('store');

        Route::patch('posts/{post}', "PostController@update")->name('update');

        Route::delete('posts/{post}', "PostController@destroy")->name('destroy');
    });