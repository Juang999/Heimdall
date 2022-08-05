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

Route::post('login', 'UserController@login');

Route::middleware('jwt.verify')->group( function () {
    Route::prefix('soship')->group( function () {
        Route::get('get-all-products', 'Api\Client\SoShipController@index');
        Route::get('get-detail-product/{soship_code}', 'Api\Client\SoShipController@show');
    });

    Route::get('/profile', 'Api\Client\Profile');
});
