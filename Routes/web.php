<?php
/**
 * web.php
 * Created by @anonymoussc on 6/27/2017 12:46 PM.
 */

Route::group(['middleware' => 'web', 'prefix' => 'signal', 'namespace' => 'App\\Components\Signal\Http\Controllers'], function () {
    Route::get('/', function() {
        \Event::fire('event.info', [['message' => 'test3']]);
        echo 'success';
    });
});

Route::get('/signal/mail', function () {

    \Mail::raw('hello world', function($message) {
        $message->subject('message subject')->to('test@example.org');
    });

    //return new App\Components\Signal\Emails\SignalMailer(['test' =>'test']);
    //Illuminate\Support\Facades\Mail::to(config('50c5ac69@opayq.com'))->send(new App\Components\Signal\Emails\SignalMailer(['test' =>'test']));
});