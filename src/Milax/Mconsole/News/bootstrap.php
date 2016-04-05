<?php

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'description' => 'Creates news for website.',
    'menu' => [
        'content' => [
            'child' => [
                'news_all' => [
                    'name' => 'All news',
                    'translation' => 'menu.news.list.name',
                    'url' => 'news',
                    'description' => 'menu.news.list.description',
                    'route' => 'mconsole.news.index',
                    'visible' => true,
                    'enabled' => true,
                ],
                'news_form' => [
                    'name' => 'Create news',
                    'translation' => 'menu.news.form.name',
                    'url' => 'news/create',
                    'description' => 'menu.news.form.description',
                    'route' => 'mconsole.news.store',
                    'visible' => true,
                    'enabled' => true,
                ],
                'news_update' => [
                    'name' => 'Edit news',
                    'translation' => 'menu.news.update.name',
                    'description' => 'menu.news.update.description',
                    'route' => 'mconsole.news.edit',
                    'visible' => false,
                    'enabled' => true,
                ],
                'news_delete' => [
                    'name' => 'Delete news',
                    'translation' => 'menu.news.delete.name',
                    'description' => 'menu.news.delete.description',
                    'route' => 'mconsole.news.destroy',
                    'visible' => false,
                    'enabled' => true,
                ],
            ],
        ],
    ],
    'register' => [
        'middleware' => [],
        'providers' => [],
        'aliases' => [],
        'bindings' => [],
        'dependencies' => [],
    ],
];
