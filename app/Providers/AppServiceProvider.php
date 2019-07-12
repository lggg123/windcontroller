<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Adapter\weatherAdapter;
use App\Http\OWMInfo;
use App\Http\Decorators\cacheWeather;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Http\Interface\owmInterface', function(){
            $base = new weatherAdapter(OWMInfo);
            $cache = new cacheWeather($base, $this->app['cache.store']);
            return $cache;
        });
        //
    }
}
