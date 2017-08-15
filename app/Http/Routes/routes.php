<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
 */
Route::group(['middleware' => ['web']], function () {
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        require app_path('Http/Routes/admin.php');
    });
    // Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
    //     require app_path('Http/Routes/user.php');
    // });
	Route::group(['prefix' => '/', 'namespace' => 'Site'], function () {
        require app_path('Http/Routes/site.php');
    });
    
});