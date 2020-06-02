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

Route::middleware('auth')->group(function(){
    //For API Access
    Route::get('/getInitialData','Front\APIController@getInitialData');
    Route::get("/list","Front\APIController@getAllListings");
    Route::get("/list/detail/{display_id}","Front\APIController@singleDetail");
});


//Route::get('/reqProperties',function(Request $request){
//
////    $request->session()->put('state', $state = Str::random(40));
//    $client=new \GuzzleHttp\Client([
//        'verify'=>false
//    ]);
//    $response=$client->request("POST","https://paigbackend.test/oauth/token",[
//        "form_params"=>[
//            'client_id' => '90af49a5-71ba-479a-a8e2-cc2ad437f9c4',
//            'client_secret'=>'U91FQj8SWg3kQsHmH0QzYIUsDcICGt9lY1cilDi3',
//            'redirect_uri' => 'http://paigbuildingservices.com.au/wp-admin',
//            'grant_type' => 'client_credentials',
//            'scope' => '*',
//        ],
////        'debug'=>true
//    ]);
//    var_dump( json_decode((string) $response->getBody(), true));
//});
