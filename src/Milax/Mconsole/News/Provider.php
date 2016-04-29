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
        $this->app->when('\Milax\Mconsole\News\Http\Controllers\NewsController')
            ->needs('\Milax\Mconsole\Contracts\Repository')
            ->give(function () {
                return new \Milax\Mconsole\News\NewsRepository(\Milax\Mconsole\News\Models\News::class);
            });
    }
}
