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

Route::get('/get_exp_types', ['middleware'=>'auth','uses'=>'GeneralController@get_exp_types']);

Route::post('/save_exp_type', ['middleware'=>'auth','uses'=>'GeneralController@save_exp_type']);

Route::post('/activate_exp_type', ['middleware'=>'auth','uses'=>'GeneralController@activate_exp_type']);

Route::post('/deactivate_income_type', ['middleware'=>'auth','uses'=>'GeneralController@deactivate_income_type']);

Route::get('/get_income_types', ['middleware'=>'auth','uses'=>'GeneralController@get_income_types']);

Route::post('/save_income_type', ['middleware'=>'auth','uses'=>'GeneralController@save_income_type']);

Route::post('/activate_income_type', ['middleware'=>'auth','uses'=>'GeneralController@activate_income_type']);

Route::post('/deactivate_exp_type', ['middleware'=>'auth','uses'=>'GeneralController@deactivate_exp_type']);

Route::get('/get_parties', ['middleware'=>'auth','uses'=>'AccountsController@get_parties']);

Route::post('/save_party', ['middleware'=>'auth','uses'=>'AccountsController@save_party']);

Route::post('/activate_party', ['middleware'=>'auth','uses'=>'AccountsController@activate_party']);

Route::post('/deactivate_party', ['middleware'=>'auth','uses'=>'AccountsController@deactivate_party']);

Route::get('/get_sources', ['middleware'=>'auth','uses'=>'AccountsController@get_sources']);

Route::post('/save_source', ['middleware'=>'auth','uses'=>'AccountsController@save_source']);

Route::post('/activate_source', ['middleware'=>'auth','uses'=>'AccountsController@activate_source']);

Route::post('/deactivate_source', ['middleware'=>'auth','uses'=>'AccountsController@deactivate_source']);

Route::get('/get_exp_details', ['middleware'=>'auth','uses'=>'AccountsController@get_exp_details']);

Route::post('/save_exp', ['middleware'=>'auth','uses'=>'AccountsController@save_exp']);

Route::get('/get_exp_list', ['middleware'=>'auth','uses'=>'AccountsController@get_exp_list']);

Route::post('/activate_exp', ['middleware'=>'auth','uses'=>'AccountsController@activate_exp']);

Route::post('/deactivate_exp', ['middleware'=>'auth','uses'=>'AccountsController@deactivate_exp']);

Route::get('/get_income_details', ['middleware'=>'auth','uses'=>'AccountsController@get_income_details']);

Route::post('/save_income', ['middleware'=>'auth','uses'=>'AccountsController@save_income']);

Route::get('/get_income_list', ['middleware'=>'auth','uses'=>'AccountsController@get_income_list']);

Route::post('/activate_income', ['middleware'=>'auth','uses'=>'AccountsController@activate_income']);

Route::post('/deactivate_income', ['middleware'=>'auth','uses'=>'AccountsController@deactivate_income']);