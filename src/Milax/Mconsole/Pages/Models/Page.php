<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use \HasImages;
    
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'system', 'enabled'];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
        'links' => 'array',
    ];
    
    public function setSlugAttribute($value)
    {
        if (strlen($value) == 0) {
            $this->attributes['slug'] = str_slug($this->heading);
        } else {
            $this->attributes['slug'] = str_slug($value);
        }
    }
    
    public function links()
    {
        return $this->hasMany('Milax\Mconsole\Pages\Models\ContentLink');
    }
    
    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($page) {
            $page->images()->delete();
            $page->links()->delete();
        });
    }
}
