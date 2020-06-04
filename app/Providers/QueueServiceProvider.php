<?php


namespace App\Providers;


use App\Mail\JobStart;
use App\Repositories\Admin\SettingRepository;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;


class QueueServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SettingRepository $setting_repo)
    {
        $settings=$setting_repo->getSettings([
            'email',
            'cc_email',
            'bcc_email'
        ]);
        if(!isset($settings["email"])){
            $settings["email"]="";
        }
        if(!isset($settings["email"])){
            $settings["cc_email"]="";
        }
        if(!isset($settings["email"])){
            $settings["bcc_email"]="";
        }
        Queue::before(function (JobProcessing $event ) use($settings){
            if($event->job->resolveName()==="API\Jobs\PaigQueue"){
                Mail::to($settings["email"])
                    ->cc($settings["cc_email"])
                    ->bcc($settings["bcc_email"])
                    ->send(new JobStart());
            }
            if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
                $msg="The job number ".$event->job->getJobId()." has been started.";
                Log::channel("paigapi")->info($msg);
            }
        });

        Queue::after(function ( JobProcessed $event ) use($settings) {
            if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
                $msg="The job number ".$event->job->getJobId()." has been finished.";
                Log::channel("paigapi")->info($msg);
                Mail::to($settings["email"])
                    ->cc($settings["cc_email"])
                    ->bcc($settings["bcc_email"])
                    ->send(new JobProcessed());
            }
        });

        Queue::failing(function ( JobFailed $event ) use($settings) {
            if($event->job->resolveName()==="API\Jobs\PaigQueue"){
                Mail::to($settings["email"])
                    ->cc($settings["cc_email"])
                    ->bcc($settings["bcc_email"])
                    ->send(new \App\Mail\JobFailed());
            }
            if($event->job->resolveName()==="App\Jobs\PaigAPIJob"){
                $msg="The job number ".$event->job->getJobId()." has been failed.";
                Log::channel('paigapi')->error($msg);
            }
        });
    }

}
