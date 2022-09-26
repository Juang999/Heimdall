<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api as Api;

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
    // userEndPoint
    Route::prefix('user')->group( function () {
        Route::get('profile', 'Api\Client\Profile');
        Route::get('history', 'Api\Client\History');
    });

    // salesOrderEndPoint
    Route::prefix('SO')->group( function () {
        Route::get('/{so_code}', 'Api\Client\SoController@show');
        Route::patch('/', 'Api\Client\SoController@update');
        Route::get('/', 'Api\Client\SoController@history');
    });

    // preOrderEndPoint
    Route::prefix('PO')->group( function () {
        Route::get('/{po_code}', 'Api\Client\PoController@show');
        Route::patch('/', 'Api\Client\PoController@update');
        Route::get('/', 'Api\Client\PoController@history');
    });

    // inventoryReceiptEndPoint
    Route::prefix('IR')->group( function () {
        Route::post('/', 'Api\Client\IrController@store');
        Route::get('/', 'Api\Client\IrController@history');
    });

    // masterDataEndpoint
    Route::get('location', 'Api\Client\MasterDataController@getLocation');
    Route::get('account', 'Api\Client\MasterDataController@getAccount');
    Route::get('partner', 'Api\Client\MasterDataController@getPartner');
    Route::get('entity', 'Api\Client\MasterDataController@getEntity');
    Route::get('site', 'Api\Client\MasterDataController@getSite');

    // checkProductEndPoint
    Route::get('/pt/{pt_syslog_code}', 'Api\Client\CheckProduct');
    Route::get('/ptCheck/{pt_code}', 'Api\Client\CheckProductWithPoCode');

    // searchProductEndPoint
    Route::post('/searchProduct', 'Api\Client\SearchProduct');
});
