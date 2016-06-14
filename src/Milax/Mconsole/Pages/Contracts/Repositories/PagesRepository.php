<?php

namespace Milax\Mconsole\Pages\Contracts\Repositories;

interface PagesRepository
{
    /**
     * Get page by slug
     * 
     * @param  string $slug
     * @param  string $lang [Language key]
     * @return Milax\Mconsole\Pages|Models\Page
     */
    public function findBySlug($slug, $lang = null);
}
