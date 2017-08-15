<?php
Route::group(['middleware' => ['auth:users']], function ($router) {
    Route::get('/', ['uses' => 'UserController@index', 'as' => 'users.index']);
    Route::post('/account', ['uses' => 'UserController@account', 'as' => 'users.account']);
    Route::get('/compose', ['uses' => 'UserController@compose', 'as' => 'users.compose']);
    Route::post('/compose', ['uses' => 'UserController@composed', 'as' => 'users.composed']);
    Route::get('/write', ['uses' => 'UserController@write', 'as' => 'users.write']);
    Route::post('/write', ['uses' => 'UserController@wrote', 'as' => 'users.wrote']);
});
Route::get('login', ['uses' => 'AuthController@index', 'as' => 'users.auth.index']);
Route::post('login', ['uses' => 'AuthController@login', 'as' => 'users.auth.login', 'middleware' => 'checkstatus']);
Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'users.auth.logout']);
Route::get('register', ['uses' => 'AuthController@getRegister', 'as' => 'users.auth.register']);
Route::post('register', ['uses' => 'AuthController@postRegister', 'as' => 'users.auth.register']);
Route::get('password/reset/{token?}', ['uses' => 'PasswordController@showResetForm', 'as' => 'users.password.reset']);
Route::post('password/reset', ['uses' => 'PasswordController@reset', 'as' => 'users.password.reset']);
Route::post('password/email', ['uses' => 'PasswordController@sendResetLinkEmail', 'as' => 'users.password.email']);
