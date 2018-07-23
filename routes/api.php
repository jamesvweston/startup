<?php


Route::group(['prefix'     => 'accounts'], function ()
{

    Route::get('/', 'AccountController@index');
    Route::post('/', 'AccountController@store');
    Route::get('/default', 'AccountController@getDefaultAccount');
    Route::get('/{id}', 'AccountController@show');
    Route::put('/{id}', 'AccountController@update');
    Route::put('/{id}/default', 'AccountController@setDefaultAccount');
    Route::get('/{id}/users', 'AccountController@getUsers');

});


Route::group(['prefix' => 'cards'], function ()
{

    Route::get('/', 'CardController@index');
    Route::post('/', 'CardController@store');
    Route::put('/{id}', 'CardController@update');
    Route::delete('/{id}', 'CardController@destroy');
    Route::put('/{id}/default', 'CardController@setDefaultCard');

});


Route::group(['prefix'     => 'countries'], function ()
{

    Route::get('/', 'CountryController@index');

});


Route::group(['prefix'     => 'invitations'], function ()
{

    Route::get('/', 'TeamInviteController@index');
    Route::post('/', 'TeamInviteController@store');
    Route::delete('/{id}', 'TeamInviteController@destroy');
    Route::put('/{id}/accept', 'TeamInviteController@accept');
});


Route::group(['prefix'     => 'plans'], function ()
{

    Route::get('/', 'PlanController@index');
    Route::post('/', 'PlanController@store');
    Route::get('/{id}', 'PlanController@show');
    Route::put('/{id}', 'PlanController@update');
    Route::delete('/{id}', 'PlanController@destroy');

});


Route::group(['prefix'     => 'roles'], function ()
{

    Route::get('/', 'RoleController@index');

});


Route::group(['prefix'     => 'subscriptions'], function ()
{

    Route::get('/', 'SubscriptionController@index');
    Route::post('/', 'SubscriptionController@store');
    Route::get('/{id}', 'SubscriptionController@show');
    Route::delete('/{id}', 'SubscriptionController@destroy');

});


Route::group(['prefix'     => 'users'], function ()
{

    Route::get('/email/resend', 'UserController@resendConfirmationEmail');
    Route::put('/{id}', 'UserController@update');
    Route::put('/{id}/password', 'UserController@updatePassword');

});
