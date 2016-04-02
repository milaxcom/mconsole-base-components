<?php

namespace Milax\Mconsole\News\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'enabled', 'published_at', 'published'];
    
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
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
    
    public function setSlugAttribute($value)
    {
        if (strlen($value) == 0) {
            $this->attributes['slug'] = str_slug($this->heading);
        } else {
            $this->attributes['slug'] = str_slug($value);
        }
    }
    
    public function setPublishedAttribute($value)
    {
        if (strlen($value) > 0) {
            $this->attributes['published_at'] = \Carbon\Carbon::createFromFormat('m/d/Y', $value);
        }
    }
    
    public function getPublishedAttribute()
    {
        return $this->published_at->format('m/d/Y');
    }
}
