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

Route::get('categories', 'Api\ApiController@categories');
Route::get('photos/{category_id}', 'Api\ApiController@photos');
Route::get('photo/{photo_id}', 'Api\ApiController@photo');
Route::get('next/{photo_id}', 'Api\ApiController@next');
Route::get('prev/{photo_id}', 'Api\ApiController@prev');
Route::get('random', 'Api\ApiController@random');

