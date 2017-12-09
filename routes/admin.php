<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/menu/get', 'MenuController@getMenu');

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::post('/password', 'UserController@updatePwd');
        Route::get('/list', 'UserController@getList');
        Route::get('/get', 'UserController@get');
        Route::get('/getUserName', 'UserController@getUserName');
        Route::post('/edit', 'UserController@edit');
        Route::post('/del', 'UserController@del');
        Route::post('/import', 'UserController@import');
        Route::get('/template', 'UserController@template');
    });

    Route::group(['prefix' => 'wage', 'namespace' => 'Wage'], function () {
//        Route::post('/password', 'UserController@updatePwd');
        Route::get('/list', 'WageController@getList');
//        Route::get('/get', 'UserController@get');
//        Route::get('/getUserName', 'UserController@getUserName');
//        Route::post('/edit', 'UserController@edit');
        Route::post('/del', 'WageController@del');
        Route::post('/import', 'WageController@import');
        Route::get('/template', 'WageController@template');
    });
});