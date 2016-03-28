<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::post('/login',"CommonController@login");

Route::post('/reset_password', ['middleware'=>'auth','uses'=>'CommonController@reset_password']);

Route::get('/checkuser', ['middleware'=>'auth','uses'=>'CommonController@checkuser']);

Route::get('/get_company', ['middleware'=>'auth','uses'=>'AdminController@get_company']);

Route::post('/save_company', ['middleware'=>'auth','uses'=>'AdminController@save_company']);

Route::post('/activate_company', ['middleware'=>'auth','uses'=>'AdminController@activate_company']);

Route::post('/deactivate_company', ['middleware'=>'auth','uses'=>'AdminController@deactivate_company']);

Route::get('/get_roles', ['middleware'=>'auth','uses'=>'GeneralController@get_roles']);

Route::get('/get_users', ['middleware'=>'auth','uses'=>'GeneralController@get_users']);

Route::post('/save_user', ['middleware'=>'auth','uses'=>'GeneralController@save_user']);

Route::post('/activate_user', ['middleware'=>'auth','uses'=>'GeneralController@activate_user']);

Route::post('/deactivate_user', ['middleware'=>'auth','uses'=>'GeneralController@deactivate_user']);

Route::get('/get_accounts', ['middleware'=>'auth','uses'=>'GeneralController@get_accounts']);

Route::post('/save_account', ['middleware'=>'auth','uses'=>'GeneralController@save_account']);

Route::post('/activate_account', ['middleware'=>'auth','uses'=>'GeneralController@activate_account']);

Route::post('/deactivate_account', ['middleware'=>'auth','uses'=>'GeneralController@deactivate_account']);