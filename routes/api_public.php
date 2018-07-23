<?php


Route::group(['prefix'     => 'users'], function ()
{

    Route::post('/', 'UserController@store');
    Route::get('/email_confirmation/{confirmation_token}', 'UserController@confirmEmail');

});
