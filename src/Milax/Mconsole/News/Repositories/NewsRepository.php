<?php

namespace Milax\Mconsole\News\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\News\Contracts\Repositories\NewsRepository as Repository;

class NewsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\News\Models\News::class;
}
