<?php

namespace Milax\Mconsole\Pages\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository as Repository;

class PagesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Pages\Models\Page::class;
}
