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

Route::middleware('apiauth')->group(function () {

    Route::resource('/artist', '\App\Http\Controllers\Api\ArtistController')
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('/record', '\App\Http\Controllers\Api\RecordController')
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});
