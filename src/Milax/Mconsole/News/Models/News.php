<?php

namespace Milax\Mconsole\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use \CascadeDelete, \HasTags, \HasUploads, \HasState;
    
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'keywords', 'indexing', 'pinned', 'enabled', 'published_at', 'published', 'author_id'];
    
    protected $dates = [
        'published_at',
    ];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
        'keywords' => 'array',
    ];

    /**
     * Check if news has full text
     * 
     * @return bool
     */
    public function hasText() {
        return !empty($this->text[\App::getLocale()]);
    }

    /**
     * Get image cover
     * 
     * @return Upload || null
     */
    public function getCover()
    {
        return $this->uploads->where('group', 'cover')->first() ?? null;
    }
}
