<?php

namespace Webzera\Payamount;

use Illuminate\Support\ServiceProvider;

class PayamountServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/./../resources/views', 'payamount');
    }
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPublishable();
    }

    private function registerPublishable()
    {
        $bashPath = dirname(__DIR__);

        $arrPublishable= [
            'migrations' => [
                "$bashPath/publishable/database/migrations" => database_path('migrations'),
            ],
            'config' => [
                "$bashPath/publishable/config/paycredentials.php" => config_path('paycredentials.php'),
            ]
        ];

        foreach ($arrPublishable as $group => $paths){
            $this->publishes($paths, $group);
        }
    }
    
}
