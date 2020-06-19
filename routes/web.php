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

Auth::routes(['register'=>false]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware("auth")->prefix("admin")->group(function(){
    Route::get("settings","Admin\SettingController@view");
    Route::post("settings","Admin\SettingController@save");
    Route::get("clients","Admin\ClientController@viewClients");
    Route::get("jobs/view",'Admin\JobController@viewJobs');
    Route::get("job/run",'Admin\JobController@runLocationListingJobs');
});

Queue::before(function (JobProcessing $event ) {
    if($event->job->resolveName()==="API\Jobs\PaigQueue"){
        Mail::to("sujan.paig@outlook.com,ramesh.paig@outlook.com")
            ->send(new JobStart());
    }
    if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
        $msg="The job number ".$event->job->getJobId()." has been started.";
        Log::channel("paigapi")->info($msg);
    }
});

Queue::after(function ( JobProcessed $event ) {
    if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
        $msg="The job number ".$event->job->getJobId()." has been finished.";
        Log::channel("paigapi")->info($msg);
    }
});

Queue::failing(function ( JobFailed $event ) {
    if($event->job->resolveName()==="API\Jobs\PaigQueue"){
        Mail::to("sujan.paig@outlook.com,ramesh.paig@outlook.com")
            ->send(new \App\Mail\JobFailed());
    }
    if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
        $msg="The job number ".$event->job->getJobId()." has been failed.";
        Log::channel('paigapi')->error($msg);
    }
});