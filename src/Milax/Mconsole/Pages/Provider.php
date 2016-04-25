<?php

namespace Milax\Mconsole\Pages;

use Illuminate\Support\ServiceProvider;
use Milax\Mconsole\Pages\Models\Page;

class Provider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('mconsole::pages.form', function ($view) {
            $links = Page::with('links')->has('links')->get()->lists('slug', 'id');
            $links->prepend(trans('mconsole::forms.options.notselected'), '0');
            $view->with('links_page_id_options', $links);
        });
    }
    
    public function register()
    {
        //
    }
}
