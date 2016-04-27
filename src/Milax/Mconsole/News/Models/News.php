<?php

namespace Milax\Mconsole\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use \CascadeDelete, \HasTags, \HasUploads, \HasState;
    
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'indexing', 'pinned', 'enabled', 'published_at', 'published'];
    
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
    ];
    
    /**
     * Transform updated_at proerty.
     * 
     * @access public
     * @return string
     */
    public function getUpdatedAttribute()
    {
        return $this->updated_at->format('m.d.Y');
    }
    
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
    
    /**
     * Set published_at date
     */
    public function setPublishedAttribute($value)
    {
        if (strlen($value) > 0) {
            $this->attributes['published_at'] = \Carbon\Carbon::createFromFormat('m/d/Y', $value);
        }
    }
    
    /**
     * Get published_at as string
     * 
     * @return string
     */
    public function getPublishedAttribute()
    {
        return $this->published_at->format('m/d/Y');
    }
}
