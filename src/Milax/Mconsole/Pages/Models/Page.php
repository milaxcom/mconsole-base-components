<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Page extends Model
{
    use \CascadeDelete, \HasUploads, \HasLinks, \HasState, \System;
    
    protected $fillable = ['slug', 'linkable_id', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'indexing', 'system', 'enabled'];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
        'links' => 'array',
    ];
}
