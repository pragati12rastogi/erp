<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $data = [];

        $general_settings =  GeneralSetting::first();
        $data = array(
            'general_settings' => $general_settings,
        );
        view()->composer('*', function ($view) use ($data) {

            try {
                $view->with([
                    
                    'general_settings' => $data['general_settings'],
                ]);

            } catch (\Exception $e) {

            }

        });
    }
}
