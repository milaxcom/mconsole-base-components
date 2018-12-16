<?php

namespace Milax\Mconsole\News\Contracts\Repositories;

interface NewsRepository
{
    /**
     * Get new by date range and paginate range
     * 
     * @param  DateTime $fromDate
     * @param  DateTime $toDate
     * @param  int $take
     * @param  int $skip
     * 
     * @return Collection
     */
    public function getByDate($fromDate = null, $toDate = null, $take = null, $skip = null);
    
    /**
     * Get localized news
     * 
     * @param  Builder $query
     * 
     * @return Collection
     */
    public function getCompiled($query = null);
    
    /**
     * Get news by slug
     * 
     * @param  string $slug
     * @param  string $lang
     * 
     * @return News
     */
    public function findBySlug($slug, $lang = null);

    /**
     * Get news by ID
     * 
     * @param  string $id
     * @param  string $lang
     * 
     * @return News
     */
    public function findById($id, $lang = null);
}
