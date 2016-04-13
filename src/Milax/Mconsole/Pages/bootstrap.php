<?php

use Milax\Mconsole\Pages\Installer;
use Milax\Mconsole\Pages\Models\Page;

return [
    'name' => 'Pages',
    'identifier' => 'mconsole-pages',
    'description' => 'mconsole::pages.module.description',
    'menu' => [
        'content' => [
            'child' => [
                'pages_all' => [
                    'name' => 'All pages',
                    'translation' => 'pages.menu.list.name',
                    'url' => 'pages',
                    'description' => 'pages.menu.list.description',
                    'route' => 'mconsole.pages.index',
                    'visible' => true,
                    'enabled' => true,
                ],
                'pages_form' => [
                    'name' => 'Create page',
                    'translation' => 'pages.menu.create.name',
                    'url' => 'pages/create',
                    'description' => 'pages.menu.create.description',
                    'route' => 'mconsole.pages.create',
                    'visible' => false,
                    'enabled' => true,
                ],
                'pages_update' => [
                    'name' => 'Edit pages',
                    'translation' => 'pages.menu.update.name',
                    'description' => 'pages.menu.update.description',
                    'route' => 'mconsole.pages.edit',
                    'visible' => false,
                    'enabled' => true,
                ],
                'pages_delete' => [
                    'name' => 'Delete pages',
                    'translation' => 'pages.menu.delete.name',
                    'description' => 'pages.menu.delete.description',
                    'route' => 'mconsole.pages.destroy',
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
    'install' => function () {
        Installer::install();
    },
    'uninstall' => function () {
        Installer::uninstall();
    },
    'init' => function () {
        // Register in search engine
        app('API')->search->register(function ($text) {
            return Page::select('id', 'slug', 'heading')->where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($page) {
                foreach ($page->heading as $lang => $heading) {
                    if (strlen($heading) > 0) {
                        break;
                    }
                }
                return [
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
