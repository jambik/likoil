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
Route::get('user/auth', 'Api\UserController@authorizeAndGetToken');
Route::get('user/info', 'Api\UserController@info')->middleware(['auth:api']);
Route::get('user/discounts', 'Api\UserController@discounts')->middleware(['auth:api']);

## Documentation
Route::get('docs', 'Api\DocumentationController@show')->middleware(['auth.basic', 'admin']);