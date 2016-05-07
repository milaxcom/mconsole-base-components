<?php

namespace Milax\Mconsole\Pages;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        //
    }
    
    public function register()
    {
        view()->composer('mconsole::pages.form', function ($view) {
            $view->with('languages', app('API')->repositories->languages->get());
        });
        
        app('API')->repositories->register('pages', new \Milax\Mconsole\Pages\PageRepository(\Milax\Mconsole\Pages\Models\Page::class));
        
        $this->app->when('\Milax\Mconsole\Pages\Http\Controllers\PagesController')
            ->needs('\Milax\Mconsole\Contracts\Repository')
            ->give(function () {
                return app('API')->repositories->pages;
            });
    }
}