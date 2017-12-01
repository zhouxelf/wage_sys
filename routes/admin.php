<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/menu/get', 'MenuController@getMenu');

    Route::group(['namespace' => 'User'], function () {
        Route::post('/user/password', 'UserController@updatePwd');
    });
});