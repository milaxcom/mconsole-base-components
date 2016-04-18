<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class ContentLink extends Model
{
    protected $fillable = ['page_id', 'url', 'title', 'order', 'enabled'];
    
    public function page()
    {
        return $this->hasOne('Milax\Mconsole\Pages\Models\Page', 'id', 'page_id');
    }
}
