<?php

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'menu' => [
        [
            'name' => 'All news',
            'key' => 'news_all',
            'translation' => 'menu.news.list.name',
            'url' => 'news',
            'description' => 'menu.news.list.description',
            'route' => 'mconsole.news.index',
            'visible' => true,
            'enabled' => true,
        ], [
            'name' => 'Create news',
            'key' => 'news_form',
            'translation' => 'menu.news.form.name',
            'url' => 'news/create',
            'description' => 'menu.news.form.description',
            'route' => 'mconsole.news.store',
            'visible' => true,
            'enabled' => true,
        ], [
            'name' => 'Edit news',
            'key' => 'news_update',
            'translation' => 'menu.news.update.name',
            'description' => 'menu.news.update.description',
            'route' => 'mconsole.news.edit',
            'visible' => false,
            'enabled' => true,
        ], [
            'name' => 'Delete news',
            'key' => 'news_delete',
            'translation' => 'menu.news.delete.name',
            'description' => 'menu.news.delete.description',
            'route' => 'mconsole.news.destroy',
            'visible' => false,
            'enabled' => true,
        ],
    ],
    'register' => [
        'middleware' => [],
        'providers' => [],
        'aliases' => [],
        'bindings' => [],
        'dependencies' => [],
    ],
    'config' => [],
    'translations' => [],
    'views' => [],
];
