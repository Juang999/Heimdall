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
    Route::apiResource('so', 'Api\Client\SoController')
    ->parameters(['so' => 'so_code'])
    ->only('index', 'show');

    Route::apiResource('soship', 'Api\Client\SoShipController')
    ->parameters(['soship' => 'soship_code'])
    ->only('index', 'show');

    Route::get('/pt/{pt_code}', 'Api\Client\CheckProduct');
});
