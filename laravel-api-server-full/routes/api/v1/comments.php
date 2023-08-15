<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth:api'
])
    ->name('comments.')
    ->namespace('\App\Http\Controllers')
    ->group(function() {
        Route::get('/comments', "CommentController@index")
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/comments/{comment}', "CommentController@show")
            ->name('show')
            ->whereNumber('comment');

        Route::post('comments', "CommentController@store")->name('store');

        Route::patch('comments/{comment}', "CommentController@update")->name('update');

        Route::delete('comments/{comment}', "CommentController@destroy")->name('destroy');
    });