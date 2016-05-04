<?php

use Milax\Mconsole\News\Installer;
use Milax\Mconsole\News\Models\News;

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'description' => 'mconsole::news.module.description',
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
            'name' => 'News',
            'translation' => 'news.menu.list.name',
            'url' => 'news',
            'description' => 'news.menu.list.description',
            'visible' => true,
            'enabled' => true,
        ], 'news', 'content');
        
        app('API')->acl->register([
            ['GET', 'news', 'news.acl.index', 'news'],
            ['GET', 'news/create', 'news.acl.create'],
            ['POST', 'news', 'news.acl.store'],
            ['GET', 'news/{news}/edit', 'news.acl.edit'],
            ['PUT', 'news/{news}', 'news.acl.update'],
            ['GET', 'news/{news}', 'news.acl.show'],
            ['DELETE', 'news/{news}', 'news.acl.destroy'],
        ]);
        
        // Register in search engine
        app('API')->search->register(function ($text) {
            return News::select('id', 'slug', 'heading')->where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($page) {
                return [
                    'icon' => 'newspaper-o',
                    'title' => $page->heading,
                    'description' => sprintf('/%s', $page->slug),
                    'link' => sprintf('/mconsole/news/%s/edit', $page->id),
                ];
            });
        });
        
        // Register in quick menu
        app('API')->quickmenu->register(function () {
            $link = new \stdClass();
            $link->icon = 'fa fa-plus';
            $link->color = 'label-success';
            $link->text = trans('mconsole::news.menu.create.name');
            $link->link = '/mconsole/news/create';
            return $link;
        });
    },
];
