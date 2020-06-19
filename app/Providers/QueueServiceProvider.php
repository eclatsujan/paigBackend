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
    public function boot()
    {
        
    }

}
