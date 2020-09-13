<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class TaskFacadeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('task', function(){
            return new \App\Facades\TaskValidation;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
