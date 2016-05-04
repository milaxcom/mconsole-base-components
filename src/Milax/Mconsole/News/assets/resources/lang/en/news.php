<?php

return [
    'module' => 'Manage news',
    'menu' => 'News',
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
    'acl' => [
        'index' => 'News: show list',
        'create' => 'News: show create form',
        'store' => 'News: saving',
        'edit' => 'News: show edit form',
        'update' => 'News: updating',
        'show' => 'News: view',
        'destroy' => 'News: delete',
    ],
];
