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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/

Route::get('maxid', 'Api\ApiController@maxId')->middleware('auth.basic');

Route::get('cards/save', 'Api\ApiController@cardsSave')->middleware('auth.basic');

Route::get('discounts/save', 'Api\ApiController@discountsSave')->middleware('auth.basic');