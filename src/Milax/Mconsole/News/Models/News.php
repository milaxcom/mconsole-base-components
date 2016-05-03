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
    
    /**
     * Automatically generate slug from heading if empty, format for url
     * 
     * @param void
     */
    public function setSlugAttribute($value)
    {
        if (strlen($value) == 0) {
            foreach (Request::input('heading') as $lang => $heading) {
                if (strlen($heading) > 0) {
                    break;
                }
            }
            $this->attributes['slug'] = str_slug($heading);
        } else {
            $this->attributes['slug'] = str_slug($value);
        }
    }
}
