<?php

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'description' => trans('mconsole::news.module.description'),
    'menu' => [
        'content' => [
            'child' => [
                'news_all' => [
                    'name' => 'All news',
                    'translation' => 'news.menu.list.name',
                    'url' => 'news',
                    'description' => 'news.menu.list.description',
                    'route' => 'mconsole.news.index',
                    'visible' => true,
                    'enabled' => true,
                ],
                'news_form' => [
                    'name' => 'Create news',
                    'translation' => 'news.menu.form.name',
                    'url' => 'news/create',
                    'description' => 'news.menu.form.description',
                    'route' => 'mconsole.news.store',
                    'visible' => true,
                    'enabled' => true,
                ],
                'news_update' => [
                    'name' => 'Edit news',
                    'translation' => 'news.menu.update.name',
                    'description' => 'news.menu.update.description',
                    'route' => 'mconsole.news.edit',
                    'visible' => false,
                    'enabled' => true,
                ],
                'news_delete' => [
                    'name' => 'Delete news',
                    'translation' => 'news.menu.delete.name',
                    'description' => 'news.menu.delete.description',
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
