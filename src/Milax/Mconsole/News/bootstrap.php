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
            'name' => 'All news',
            'translation' => 'news.menu.list.name',
            'url' => 'news',
            'description' => 'news.menu.list.description',
            'route' => 'mconsole.news.index',
            'visible' => true,
            'enabled' => true,
        ], 'news_all', 'content');
        app('API')->menu->push([
            'name' => 'Create news',
            'translation' => 'news.menu.create.name',
            'url' => 'news/create',
            'description' => 'news.menu.create.description',
            'route' => 'mconsole.news.create',
            'visible' => false,
            'enabled' => true,
        ], 'news_form', 'content');
        app('API')->menu->push([
            'name' => 'Edit news',
            'translation' => 'news.menu.update.name',
            'description' => 'news.menu.update.description',
            'route' => 'mconsole.news.edit',
            'visible' => false,
            'enabled' => true,
        ], 'news_update', 'content');
        app('API')->menu->push([
            'name' => 'Delete news',
            'translation' => 'news.menu.delete.name',
            'description' => 'news.menu.delete.description',
            'route' => 'mconsole.news.destroy',
            'visible' => false,
            'enabled' => true,
        ], 'news_delete', 'content');
        
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
