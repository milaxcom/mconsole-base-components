<?php

return [
    'module' => [
        'description' => 'Manage news',
    ],
    'menu' => [
        'list' => [
            'name' => 'News',
            'description' => 'List news',
        ],
        'create' => [
            'name' => 'Add news',
            'description' => 'Add an entry in news feed',
        ],
        'update' => [
            'name' => 'Edit news',
            'description' => 'Update information in added news',
        ],
        'delete' => [
            'name' => 'Delete news',
            'description' => 'Delete from news feed',
        ],
    ],
    'table' => [
        'published' => 'Published',
        'updated' => 'Updated',
        'slug' => 'Address',
        'heading' => 'Title',
    ],
    'form' => [
        'indexing' => 'Search engines indexing',
        'pinned' => 'Pinned to top',
        'published_at' => 'Published at',
        'heading' => 'Title',
        'slug' => 'Slug',
        'preview' => 'Preview text',
        'text' => 'Full text',
        'seo' => 'SEO Settings',
        'title' => 'Title',
        'description' => 'Description',
        'gallery' => 'Gallery',
        'cover' => 'Cover',
    ],
    'settings' => [
        'index' => 'Number of news at index page',
        'archive' => 'Number of news in archive',
        'gallery' => 'Use galleries',
        'cover' => 'Use cover',
        'group' => [
            'name' => 'News',
        ],
    ],
];
