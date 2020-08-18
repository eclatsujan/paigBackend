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

Route::middleware(['client_credentials'])->group(function(){
    //For API Access
    Route::get('/getInitialData','Front\APIController@getInitialData');
    Route::get('/getB2BPartners','Front\APIController@getB2BPartners');
    Route::get('/getBuildContractDevelopers','Front\APIController@getBuildContractDevelopers');
    Route::get("/list","Front\APIController@getAllListings");
    Route::get("/list/detail/{display_id}","Front\APIController@singleDetail");
    Route::get("/suggestedKeyword","Front\APIController@suggestKeyword");
});
