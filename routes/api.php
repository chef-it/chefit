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

Route::group(['prefix' => 'v1'], function()
{
    Route::resource('authenticate', 'API\AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'API\AuthenticateController@authenticate');
    Route::post('test', 'API\AuthenticateController@test');
    Route::resource('masterlist', 'API\MasterlistController', ['only' => ['index', 'store', 'edit']]);
});
