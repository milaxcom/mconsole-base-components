<?php

use Milax\Mconsole\Pages\Installer;
use Milax\Mconsole\Pages\Models\Page;

return [
    'name' => 'Pages',
    'identifier' => 'mconsole-pages',
    'description' => 'mconsole::pages.module',
    'register' => [
        'middleware' => [],
        'providers' => [
            \Milax\Mconsole\Pages\Provider::class,
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
            'name' => 'Pages',
            'translation' => 'pages.menu',
            'url' => 'pages',
            'visible' => true,
            'enabled' => true,
        ], 'pages', 'content');
        
        app('API')->acl->register([
            ['GET', 'pages', 'pages.acl.index', 'pages'],
            ['GET', 'pages/create', 'pages.acl.create'],
            ['POST', 'pages', 'pages.acl.store'],
            ['GET', 'pages/{pages}/edit', 'pages.acl.edit'],
            ['PUT', 'pages/{pages}', 'pages.acl.update'],
            ['GET', 'pages/{pages}', 'pages.acl.show'],
            ['DELETE', 'pages/{pages}', 'pages.acl.destroy'],
        ]);
        
        // Register in search engine
        app('API')->search->register(function ($text) {
            return Page::select('id', 'slug', 'heading')->where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($page) {
                foreach ($page->heading as $lang => $heading) {
                    if (strlen($heading) > 0) {
                        break;
                    }
                }
                return [
                    'icon' => 'file-text-o',
                    'title' => $heading,
                    'description' => str_limit(url(sprintf('/%s', $page->slug)), 45),
                    'link' => sprintf('/mconsole/pages/%s/edit', $page->id),
                ];
            });
        });
        
        // Register in quick menu
        app('API')->quickmenu->register(function () {
            $link = new \stdClass();
            $link->icon = 'fa fa-plus';
            $link->color = 'label-success';
            $link->text = trans('mconsole::pages.menu.create.name');
            $link->link = '/mconsole/pages/create';
            return $link;
        });
    },
];
