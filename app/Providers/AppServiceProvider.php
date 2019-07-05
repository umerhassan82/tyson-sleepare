<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\Config\Config;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $callback = function () {
//            return false;
//        };

        Schema::defaultStringLength(191);

        // $this->app->bind('path.public', function() {
        // 	  return base_path().'/newyork';
        //     });
        
        Config::load();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
