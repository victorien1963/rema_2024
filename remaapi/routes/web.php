<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('customer', 'api\CustomerController@index');
Route::get('customer/{userInfo}', 'api\CustomerController@show');
Route::post('customer', 'api\CustomerController@store');
Route::put('customer/{userInfo}', 'api\CustomerController@update');
Route::delete('customer/{userInfo}', 'api\CustomerController@destroy');
// Route::apiResource('customer', 'api\CustomerController');
//訂單
Route::get('sel_order', 'api\CustomerController@sel_order');
Route::get('cre_order', 'api\CustomerController@cre_order');
Route::get('upd_order', 'api\CustomerController@upd_order');
Route::get('upd_order_complete', 'api\CustomerController@upd_order_complete');
Route::get('get_order_note', 'api\CustomerController@get_order_note');
Route::get('upd_order_cancel', 'api\CustomerController@upd_order_cancel');
//會員
Route::get('cre_member', 'api\CustomerController@cre_member');
Route::get('cre_member_one', 'api\CustomerController@cre_member_one');
//庫存量
Route::get('get_stock', 'api\CustomerController@get_stock');
Route::get('get_stock_one', 'api\CustomerController@get_stock_one');
Route::get('get_stock_api', 'api\CustomerController@get_stock_api');

//API Log紀錄
Route::get('api_view' , 'api\ApiViewController@index');

//建立會員API
Route::post('add_user','api\AddUserController@index');

Route::get('update','api\AddUserController@update');

Route::get('sendMail','api\CustomerController@sendMail');