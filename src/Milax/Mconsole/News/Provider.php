<?php

namespace Milax\Mconsole\News;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        //
    }
    
    public function register()
    {
        view()->composer('mconsole::news.form', function ($view) {
            $view->with('languages', app('API')->repositories->languages->get());
        });
        
        app('API')->repositories->register('news', new \Milax\Mconsole\News\NewsRepository(\Milax\Mconsole\News\Models\News::class));
        
        $this->app->when('\Milax\Mconsole\News\Http\Controllers\NewsController')
            ->needs('\Milax\Mconsole\Contracts\Repository')
            ->give(function () {
                return app('API')->repositories->news;
            });
    }
}
