<?php

namespace Milax\Mconsole\Pages\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository as Repository;
use Milax\Mconsole\Contracts\ContentCompiler;
use View;

class PagesRepository extends EloquentRepository implements Repository
{
    protected $compiler, $localizator;

    public $model = \Milax\Mconsole\Pages\Models\Page::class;
    
    public function __construct(ContentCompiler $compiler)
    {
        $this->compiler = $compiler;
    }
    
    public function findBySlug($slug, $lang = null)
    {
        $page = $this->query()->where('slug', $slug)->firstOrFail();
        $localized = $this->compiler->set($page)->localize($lang)->render()->get();
        
        View::share('pageTitle', $localized->compiled->title);
        View::share('pageDescription', $localized->compiled->description);
        
        return $localized;
    }
}
