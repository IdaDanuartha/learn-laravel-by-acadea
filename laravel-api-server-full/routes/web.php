<?php

use App\Events\ChatMessageEvent;
use App\Mail\WelcomeMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/shared/posts/{post}', function(Request $request, Post $post) { 
    return "Testing share video with id {$post->id}";
})->name('shared.post')->middleware('signed');

if(App::environment('local')) {
    
    Lang::setLocale('id');
    // $trans = __('auth.password');
    // $trans = __("welcome");
    // $trans = trans_choice('auth.pants', -4);
    // $trans = trans_choice('auth.apples', 1, ['baskets' => 2]);
    // $trans = __('auth.welcome', ['name' => 'sam']);
    // dd($trans);

    // Route::get('/shared/video/{video}', function(Request $request, $video) {
    //     return 'this is link that can expired in 5 seconds later';
    // })->name('share-video')->middleware('signed');

    Route::get('/playground', function() {
        // event(new PlaygroundEvent());
        // $url = URL::temporarySignedRoute('share-video', now()->addSeconds(5), [
        //     'video' => 123
        // ]);
        // return $url;

        // $user = User::factory()->make();
        // Mail::to($user)->send(new WelcomeMail($user));
        return null;
        // return (new WelcomeMail(User::factory()->make()))->render();
    });

}

Route::get('/ws', function() {
    return view('websockets');
});

Route::post('/chat-message', function(Request $request) {
    event(new ChatMessageEvent($request->message));
    return null;
});