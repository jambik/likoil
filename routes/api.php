<?php

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

## Export routes
Route::get('maxid', 'Api\ImportController@maxId')->middleware(['auth.basic', 'export']);
Route::post('cards/save', 'Api\ImportController@cardsSave')->middleware(['auth.basic', 'export']);
Route::post('discounts/save', 'Api\ImportController@discountsSave')->middleware(['auth.basic', 'export']);

## Azs routes
Route::get('settings', 'Api\AzsController@settings')->middleware(['auth.basic', 'azs']);
Route::match(['get', 'post'], 'card/info', 'Api\AzsController@cardInfo')->middleware(['auth.basic', 'azs']);
Route::match(['get', 'post'], 'card/withdraw', 'Api\AzsController@cardWithdraw')->middleware(['auth.basic', 'azs']);

## User routes
Route::get('user/getpassword', 'Api\UserController@getPassword');
Route::get('user/auth', 'Api\UserController@authorizeAndGetToken');
Route::get('user/push', 'Api\UserController@push')->middleware(['auth:api']);
Route::get('user/info', 'Api\UserController@info')->middleware(['auth:api']);
Route::get('user/bonuses', 'Api\UserController@bonuses')->middleware(['auth:api']);
Route::get('user/withdrawals', 'Api\UserController@withdrawals')->middleware(['auth:api']);
Route::get('user/discounts', 'Api\UserController@discounts')->middleware(['auth:api']);
Route::get('user/gas_stations', 'Api\UserController@gasStations')->middleware(['auth:api']);
Route::get('user/news', 'Api\UserController@news')->middleware(['auth:api']);
Route::get('user/news_read', 'Api\UserController@newsRead')->middleware(['auth:api']);
//Route::post('user/news_read', 'Api\UserController@newsRead')->middleware(['auth:api']);
Route::post('user/feedback', 'Api\UserController@feedback')->middleware(['auth:api']);
Route::get('user/oil_changes', 'Api\UserController@oilChanges')->middleware(['auth:api']);
Route::post('user/oil_changes/add', 'Api\UserController@addOilChange')->middleware(['auth:api']);
Route::post('user/oil_changes/update', 'Api\UserController@updateOilChange')->middleware(['auth:api']);
Route::post('user/oil_changes/delete', 'Api\UserController@deleteOilChange')->middleware(['auth:api']);

## Documentation
//Route::get('docs', 'Api\DocumentationController@show')->middleware(['auth']);