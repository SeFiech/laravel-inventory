<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// API V1

//Route::get('loginindex', 'Api\v1\LoginController@index');

Route::group(['prefix' => '/v1', 'namespace' => 'Api\v1'], function () {
    Route::post('login', 'LoginController@login');
    Route::get('loginindex', 'LoginController@index');
  });
