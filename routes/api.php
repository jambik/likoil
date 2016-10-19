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

Route::get('maxid', 'Api\ImportController@maxId')->middleware('auth.basic');
Route::post('cards/save', 'Api\ImportController@cardsSave')->middleware('auth.basic');
Route::post('discounts/save', 'Api\ImportController@discountsSave')->middleware('auth.basic');

Route::get('settings', 'Api\AzsController@settings')->middleware('auth.basic');
Route::match(['get', 'post'], 'card/info', 'Api\AzsController@cardInfo')->middleware('auth.basic');
Route::match(['get', 'post'], 'card/withdraw', 'Api\AzsController@cardWithdraw')->middleware('auth.basic');

## Documentation
Route::get('docs', 'Api\DocumentationController@show')->middleware('auth.basic');