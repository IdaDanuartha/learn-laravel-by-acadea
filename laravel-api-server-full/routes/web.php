<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/app', function() {
    return view('app');
});

if(App::environment('local')) {
    
    Lang::setLocale('id');
    // $trans = __('auth.password');
    $trans = __("welcome");
    $trans = trans_choice('auth.pants', -4);
    $trans = trans_choice('auth.apples', 1, ['baskets' => 2]);
    $trans = __('auth.welcome', ['name' => 'sam']);
    dd($trans);

    Route::get('/playground', function() {
        $user = User::factory()->make();
        Mail::to($user)->send(new WelcomeMail($user));
        return null;
        // return (new WelcomeMail(User::factory()->make()))->render();
    });

}