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

Route::get('maxid', 'Api\ApiController@maxId')->middleware('auth.basic');

Route::post('cards/save', 'Api\ApiController@cardsSave')->middleware('auth.basic');

Route::post('discounts/save', 'Api\ApiController@discountsSave')->middleware('auth.basic');