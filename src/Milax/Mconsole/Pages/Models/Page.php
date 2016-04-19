<?php

namespace Milax\Mconsole\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Page extends Model
{
    use \HasUploads;
    
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'indexing', 'system', 'enabled'];
    
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
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($page) {
            $page->links()->delete();
            $object->uploads->each(function ($upload) {
                $upload->delete();
            });
        });
    }
}
