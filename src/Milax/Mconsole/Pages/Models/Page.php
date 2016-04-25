<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Page extends Model
{
    use \HasUploads, \HasState, \System;
    
    protected $fillable = ['slug', 'links_page_id', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'indexing', 'system', 'enabled'];
    
    protected $casts = [
        'heading' => 'array',
        'preview' => 'array',
        'text' => 'array',
        'title' => 'array',
        'description' => 'array',
        'links' => 'array',
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
    
    /**
     * Relationship to ContentLinks
     * 
     * @return HasMany
     */
    public function links()
    {
        return $this->hasMany('Milax\Mconsole\Pages\Models\ContentLink');
    }
    
    /**
     * Get all links
     * 
     * @return HasMany
     */
    public function allLinks()
    {
        return $this->hasMany('Milax\Mconsole\Pages\Models\ContentLink')->orWhere('content_links.page_id', $this->links_page_id);
    }
    
    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($object) {
            $object->links()->delete();
            $object->uploads->each(function ($upload) {
                $upload->delete();
            });
        });
    }
}
