<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin\User'], function () {
    Route::get('/menu/get', 'MenuController@getMenu');
});