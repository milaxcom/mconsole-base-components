<?php

namespace Milax\Mconsole\Pages\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository as Repository;
use Milax\Mconsole\Contracts\ContentCompiler;

class PagesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Pages\Models\Page::class;
    
    public function __construct(ContentCompiler $compiler)
    {
        $this->compiler = $compiler;
    }
    
    public function findBySlug($slug, $lang = null)
    {
        $page = $this->query()->where('slug', $slug)->firstOrFail();
        return $this->compiler->set($page)->localize($lang)->render()->get();
    }
}
