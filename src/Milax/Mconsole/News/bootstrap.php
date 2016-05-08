<?php

use Milax\Mconsole\News\Installer;
use Milax\Mconsole\News\Models\News;

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'description' => 'mconsole::news.module',
    'register' => [
        'middleware' => [],
        'providers' => [
            \Milax\Mconsole\News\Provider::class,
        ],
        'aliases' => [],
        'bindings' => [],
        'dependencies' => [],
    ],
    'install' => function () {
        Installer::install();
    },
    'uninstall' => function () {
        Installer::uninstall();
    },
    'init' => function () {
        app('API')->menu->push([
            'name' => 'mconsole::news.menu',
            'url' => 'news',
            'visible' => true,
            'enabled' => true,
        ], 'news', 'content');
        
        app('API')->acl->register([
            ['GET', 'news', 'mconsole::news.acl.index', 'news'],
            ['GET', 'news/create', 'mconsole::news.acl.create'],
            ['POST', 'news', 'mconsole::news.acl.store'],
            ['GET', 'news/{news}/edit', 'mconsole::news.acl.edit'],
            ['PUT', 'news/{news}', 'mconsole::news.acl.update'],
            ['GET', 'news/{news}', 'mconsole::news.acl.show'],
            ['DELETE', 'news/{news}', 'mconsole::news.acl.destroy'],
        ]);
        
        // Register in search engine
        app('API')->search->register(function ($text) {
            return News::select('id', 'slug', 'heading')->where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($result) {
                return [
                    'title' => $result->heading,
                    'description' => sprintf('/%s', $result->slug),
                    'link' => sprintf('/mconsole/news/%s/edit', $result->id),
                    'tags' => ['news', sprintf('#%s', $result->id)],
                ];
            });
        });
        
        // Register in quick menu
        app('API')->quickmenu->register(function () {
            return [
                'text' => trans('mconsole::news.quickmenu.create'),
                'link' => '/mconsole/news/create',
            ];
        });
    },
];
