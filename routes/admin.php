<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/menu/get', 'MenuController@getMenu');

    Route::group(['namespace' => 'User'], function () {
        Route::post('/user/password', 'UserController@updatePwd');

        Route::get('/user/list', 'UserController@getList');
        Route::get('/user/get', 'UserController@get');
        Route::post('/user/edit', 'UserController@edit');
        Route::post('/user/del', 'UserController@del');
        Route::post('/user/import', 'UserController@import');
        Route::get('/user/template', 'UserController@template');
    });
});