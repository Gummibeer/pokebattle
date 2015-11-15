<?php

namespace App\Providers;

use App\Libs\AlertBuilder;
use App\Libs\FormBuilder;
use App\Libs\FilterBuilder;
use Illuminate\Support\ServiceProvider;

class HtmlBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bindShared('alertbuilder', function($app) {
            return new AlertBuilder($app['html']);
        });
    }

    public function provides()
    {
        return [
            'alertbuilder',
        ];
    }
}
