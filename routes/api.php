<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function(){
    Route::post('/user_register_api', 'api\LoginAPIController@user_register_api')->name('login_api');
    Route::post('/get_user_info_api', 'api\CommonController@get_user_info')->middleware('jwt.auth');
    Route::post('/user_login_api', 'api\LoginAPIController@user_login_api')->middleware('jwt.auth');
    Route::post('/user_update_info_api', 'api\LoginAPIController@user_update_info_api')->middleware('jwt.auth');
    Route::post('/link_user_to_sns_api', 'api\SnsController@link_to_sns')->middleware('jwt.auth');
    Route::get('/get_category_api', 'api\CommonController@get_category_info')->middleware('jwt.auth');
    Route::get('/logout_api', 'api\LoginAPIController@logout_out')->middleware('jwt.auth');
    Route::post('/remove_sns_acc_api', 'api\SnsController@delete_sns_user')->middleware('jwt.auth');
    Route::get('/get_sns_info_api', 'api\CommonController@get_sns_info')->middleware('jwt.auth');
    Route::get('/deactive_user_api', 'api\CommonController@deactive_acc')->middleware('jwt.auth');
    Route::get('/request_deactive_user_api', 'api\CommonController@request_deactive_acc')->middleware('jwt.auth');
    Route::post('/user_register_email_api', 'api\LoginAPIController@user_register_email');
    Route::post('/user_login_email_api', 'api\LoginAPIController@login_by_email');
    Route::post('/send_reset_password_api', 'api\LoginAPIController@send_email_reset_password');
    Route::post('/active_user_api', 'api\LoginAPIController@active_user')->middleware('jwt.auth');
    Route::post('/reset_password_api', 'api\LoginAPIController@reset_password')->middleware('jwt.auth');

});
