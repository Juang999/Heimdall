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
    Route::prefix('so')->group( function () {
        Route::get('/{so_code}', 'Api\Client\SoController@show');
        Route::patch('/{sod_oid}', 'Api\Client\SoController@update');
    });

    Route::prefix('user')->group( function () {
        Route::get('profile', 'Api\Client\Profile');
        Route::get('history', 'Api\Client\History');
    });

    Route::get('/pt/{pt_code}', 'Api\Client\CheckProduct');
});

Route::get('testing', 'Testing\TestingController@getTime');
