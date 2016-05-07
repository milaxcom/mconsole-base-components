<?php

namespace Milax\Mconsole\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use \CascadeDelete, \HasTags, \HasUploads, \HasState;
    
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'indexing', 'pinned', 'enabled', 'published_at', 'published'];
    
    protected $dates = [
        'published_at',
    ];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
    ];
}
