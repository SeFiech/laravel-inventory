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


Route::middleware(['cors', 'json.response', 'auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

// API V1

Route::group(['prefix' => '/v1', 'namespace' => 'Api\v1'], function () {
    Route::group(['middleware' => ['cors', 'json.response']], function () {

        Route::post('/login', 'AuthController@login')->name('login.api');
        Route::post('/register', 'AuthController@register')->name('register.api');


    });
});


Route::group(['prefix' => '/v1', 'namespace' => 'Api\v1'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'AuthController@logout')->name('logout.api');

        Route::get('/products', 'ProductController@index')->name('products.api');
    });
});

// Route::group(['middleware' => ['auth:api']], ['prefix' => '/v1', 'namespace' => 'Api\v1'], function () {
//     Route::post('/logout', 'AuthController@logout')->name('logout.api');
// });

// Route::group(['middleware' => ['cors', 'json.response']], ['prefix' => '/v1', 'namespace' => 'Api\v1'], function () {
//     Route::post('/login', 'AuthController@login')->name('login.api');
//     Route::post('/register', 'AuthController@register')->name('register.api');


    //Route::post('login', 'AuthController@login');
//});
