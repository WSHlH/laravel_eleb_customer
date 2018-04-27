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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//商家列表接口
Route::get('/businessList','ApiController@businessList');
//商家详细信息接口
Route::get('/business','ApiController@business');

//发送短信接口
Route::get('/sms','CustomerController@sendSms');
//注册用户接口
Route::post('/regist','CustomerController@regist');
//用户登录接口
Route::post('/login','CustomerController@store');
