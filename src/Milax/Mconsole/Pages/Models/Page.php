<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Page extends Model
{
    use \HasUploads, \HasLinks, \HasState, \System;
    
    protected $fillable = ['slug', 'linkable_id', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'indexing', 'system', 'enabled'];
    
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
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($object) {
            app('API')->links->detach($object);
            $object->uploads->each(function ($upload) {
                $upload->delete();
            });
        });
    }
}
