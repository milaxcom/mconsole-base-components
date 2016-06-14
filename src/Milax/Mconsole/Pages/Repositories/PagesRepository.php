<?php

namespace Milax\Mconsole\Pages\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository as Repository;
use Milax\Mconsole\Contracts\ContentLocalizator;

class PagesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Pages\Models\Page::class;
    
    public function __construct(ContentLocalizator $localizator)
    {
        $this->localizator = $localizator;
    }
    
    public function findBySlug($slug, $lang = null)
    {
        $page = $this->query()->where('slug', $slug)->firstOrFail();
        return $this->localizator->localize($page, $lang);
    }
}
