<?php

use Milax\Mconsole\News\Installer;
use Milax\Mconsole\News\Models\News;

return [
    'name' => 'News',
    'identifier' => 'mconsole-news',
    'description' => 'mconsole::news.module.description',
    'register' => [
        'middleware' => [],
        'providers' => [],
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
        app('API')->menu->push('content', 'news_all', [
            'name' => 'All news',
            'translation' => 'news.menu.list.name',
            'url' => 'news',
            'description' => 'news.menu.list.description',
            'route' => 'mconsole.news.index',
            'visible' => true,
            'enabled' => true,
        ]);
        app('API')->menu->push('content', 'news_form', [
            'name' => 'Create news',
            'translation' => 'news.menu.create.name',
            'url' => 'news/create',
            'description' => 'news.menu.create.description',
            'route' => 'mconsole.news.create',
            'visible' => false,
            'enabled' => true,
        ]);
        app('API')->menu->push('content', 'news_update', [
            'name' => 'Edit news',
            'translation' => 'news.menu.update.name',
            'description' => 'news.menu.update.description',
            'route' => 'mconsole.news.edit',
            'visible' => false,
            'enabled' => true,
        ]);
        app('API')->menu->push('content', 'news_delete', [
            'name' => 'Delete news',
            'translation' => 'news.menu.delete.name',
            'description' => 'news.menu.delete.description',
            'route' => 'mconsole.news.destroy',
            'visible' => false,
            'enabled' => true,
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
