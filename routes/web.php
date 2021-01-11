<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use App\Mail\JobStart;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware("auth")->prefix("admin")->group(function () {
    Route::get("settings", "Admin\SettingController@view");
    Route::post("settings", "Admin\SettingController@save");
    Route::get("clients", "Admin\ClientController@viewClients");
    Route::get("jobs/view", 'Admin\JobController@viewJobs');
    Route::get("job/run", 'Admin\JobController@runLocationListingJobs');
    Route::get("job/test", 'Admin\JobController@testSingleJob');
});

Route::get("test", function () {
    $domains = [
        "projects.paigtechnologies.com.au",
        "paigbuildingservices.com.au",
        "nationaldisabilityhouses.com.au",
        "projects.reaprojects.com.au",
        "buyrenovate.com.au",
        "townies.com.au",
        "letsbuyaunit.com.au",
        "villasinaustralia.com.au",
        "buyawarehouse.com.au",
        "businessbroking.com.au",
        "buyterraces.com.au",
        "projects.professionalsblacktown.com.au",
        "projects.goldennest.com.au",
        "uwp.hashtagportal.com.au",
        "divinehomes.hashtagportal.com.au",
        "inspiredpropertyinvesting.hashtagportal.com.au",
        "squareyards.hashtagportal.com.au",
        "eikogroup.hashtagportal.com.au",
        "meridianaustralia.hashtagportal.com.au",
        "hashtagcustomhomes.com.au",
        "projects.meridianaustralia.com.au",
        "hashtagcustombuilds.com.au",
        "buycommercialrealestate.com.au",
        "developmentsinrealestate.com.au",
        "existingrealestate.com.au",
        "grannyflatrealestate.com.au",
        "houseandlandproperties.com.au",
        "newlandestate.com.au",
        "offtheplanpurchase.com.au",
        "smsfrealestate.com.au",
        "builddesigns.com.au",
        "dualdwellings.com.au",
        "ddpproperty.hashtagportal.com.au",
        "projects.simonehomes.com.au",
        "highincomeproperties.com.au",
        "ljhookerminto.hashtagportal.com.au",
        "landandlease.hashtagportal.com.au",
        "sapphireestateagents.hashtagportal.com.au",
        "ddpprojects.com.au",
        "strategicrealty.hashtagportal.com.au",
        "dualentryproperties.com.au",
        "www.hashtagregionalhomes.com.au",
        "landhar.hashtagportal.com.au",
        "ssrgproperties.hashtagportal.com.au",
        "novolink.hashtagportal.com.au",
    ];
    foreach($domains as $domain){
        $result=dns_get_record($domain);
        echo "<pre>";
        var_dump(checkdnsrr($domain,'A'));
        print_r($result);
        echo "</pre>";
    }
});
