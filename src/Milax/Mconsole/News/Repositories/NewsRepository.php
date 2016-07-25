<?php

namespace Milax\Mconsole\News\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\News\Contracts\Repositories\NewsRepository as Repository;
use Milax\Mconsole\Contracts\ContentCompiler;

class NewsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\News\Models\News::class;
    
    public function __construct(ContentCompiler $compiler)
    {
        $this->compiler = $compiler;
    }
    
    public function getCompiled()
    {
        $news = $this->query()->enabled()->get();
        
        foreach ($news as $key => $new) {
            $news[$key] = $this->findBySlug($new->slug, \App::getLocale());
        }
        
        return $news;
    }
    
    public function findBySlug($slug, $lang = null)
    {
        $page = $this->query()->where('slug', $slug)->firstOrFail();
        return $this->compiler->set($page)->localize($lang)->render()->get();
    }
}
