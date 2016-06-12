<?php

namespace Milax\Mconsole\News;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('mconsole::news.form', function ($view) {
            $view->with('languages', app('Milax\Mconsole\Contracts\Repositories\LanguagesRepository')->get());
        });
    }
    
    public function register()
    {
        $this->app->bind('Milax\Mconsole\News\Contracts\Repositories\NewsRepository', 'Milax\Mconsole\News\Repositories\NewsRepository');
    }
}
