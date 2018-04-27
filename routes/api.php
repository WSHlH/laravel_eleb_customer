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


//修改密码
Route::post('/changePassword','CustomerController@changePwd');
//忘记密码
Route::post('/forgetPassword','CustomerController@forgetPwd');


//查看收货地址列表
Route::get('/addressList','AddressController@addressList');
//添加收货地址
Route::post('/addAddress','AddressController@addAddress');
//查看修改收货地址
Route::get('/address','AddressController@address');
//修改收货地址
Route::post('/editAddress','AddressController@editAddress');
//删除收货地址
Route::get('/addressDelete','AddressController@addressDelete');

//添加购物车
Route::post('/addCart','CartsController@store');
//显示购物车内容
Route::get('/cart','CartsController@show');


