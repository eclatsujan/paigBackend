<?php


namespace App\Providers;


use App\Repositories\Admin\SettingRepository;
use App\Repositories\Contracts\SettingRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(SettingRepositoryContract::class, SettingRepository::class);
    }
}
