<?php
/**
 * web.php
 * Created by @anonymoussc on 6/27/2017 12:46 PM.
 */

Route::group(['middleware' => 'web', 'prefix' => 'signal', 'namespace' => 'App\\Components\Signal\Http\Controllers'], function () {
    Route::get('/', 'SignalController@index');
});