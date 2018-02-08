<?php

return [
    'module' => 'Manage news',
    'quickmenu' => [
        'create' => 'Add news',
    ],
    'menu' => 'News',
    'table' => [
        'published' => 'Published',
        'updated' => 'Updated',
        'slug' => 'Address',
        'heading' => 'Heading',
    ],
    'form' => [
        'indexing' => 'Search engines indexing',
        'pinned' => 'Pinned to top',
        'published_at' => 'Published at',
        'heading' => 'Heading',
        'slug' => 'Slug',
        'preview' => 'Preview text',
        'text' => 'Full text',
        'seo' => 'SEO Settings',
        'title' => 'Title',
        'description' => 'Description',
        'keywords' => 'Keywords',
        'gallery' => 'Gallery',
        'cover' => 'Cover',
        'slugify' => 'Generate',
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
