<?php

namespace Milax\Mconsole\Pages;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('mconsole::pages.form', function ($view) {
            $view->with('languages', app('Milax\Mconsole\Contracts\Repositories\LanguagesRepository')->get());
        });
    }
    
    public function register()
    {
        $this->app->bind('Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository', 'Milax\Mconsole\Pages\Repositories\PagesRepository');
    }
}
