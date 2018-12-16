<?php

namespace Milax\Mconsole\News\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\News\Contracts\Repositories\NewsRepository as Repository;
use Milax\Mconsole\Contracts\ContentCompiler;
use Milax\Mconsole\Traits\Repositories\TaggableRepository;

class NewsRepository extends EloquentRepository implements Repository
{
    use TaggableRepository;
    
    public $model = \Milax\Mconsole\News\Models\News::class;
    
    public function __construct(ContentCompiler $compiler)
    {
        $this->compiler = $compiler;
    }
    
    public function getByDate($fromDate = null, $toDate = null, $take = null, $skip = null, $tag = null)
    {
        if (!is_null($tag)) {
            $query = $this->tagQuery($tag);
        } else {
            $query = $this->query();
        }
        
        $query = $query->orderBy('pinned', 'desc')->orderBy('published_at', 'desc');
        
        if (!is_null($fromDate)) {
            $query->where('published_at', '>=', $fromDate);
        }
        
        if (!is_null($toDate)) {
            $query->where('published_at', '<=', $toDate);
        }
        
        if (!is_null($take)) {
            $query->take($take);
            
            if (!is_null($skip)) {
                $query->skip($skip);
            }
        }
        
        return $this->getCompiled($query);
    }
    
    public function getCompiled($query = null)
    {
        if (is_null($query)) {
            $query = $this->query()->enabled();
        } else {
            $query = $query->enabled();
        }
        
        $news = $query->get();
        
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

    public function findById($id, $lang = null)
    {
        $page = $this->query()->where('id', $id)->firstOrFail();
        return $this->compiler->set($page)->localize($lang)->render()->get();
    }
}
