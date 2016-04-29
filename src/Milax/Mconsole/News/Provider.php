<?php

namespace Milax\Mconsole\News;

use Illuminate\Support\ServiceProvider;
use Milax\Mconsole\News\NewsRepository;
use Milax\Mconsole\News\Models\News;

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
                return new NewsRepository(News::class);
            });
    }
}
