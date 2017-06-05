<?php

Route::group(['middleware' => 'web', 'prefix' => 'signal', 'namespace' => 'App\\Components\Signal\Http\Controllers'], function () {
    Route::get('/', 'SignalController@index');
});
