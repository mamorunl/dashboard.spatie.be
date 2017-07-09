<?php

Route::group(['middleware' => 'auth.very_basic'], function () {
    Route::get('/', 'DashboardController@index');
    Route::post('/pusher/authenticate', 'PusherController@authenticate');
    
    Route::get('/nest', 'NestController@index');
    Route::get('/nest/authorize', 'NestController@authorizeApp');
    Route::get('/nest/temperature', 'NestController@getTemperature');
});

Route::post('/webhook/github', 'GitHubWebhookController@gitRepoReceivedPush');
