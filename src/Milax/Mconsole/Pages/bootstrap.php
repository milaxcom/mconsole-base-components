<?php

return [
    'name' => 'Pages',
    'identifier' => 'mconsole-pages',
    'description' => trans('mconsole::pages.module.description'),
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
                    'description' => 'pages.menu.form.description',
                    'route' => 'mconsole.pages.create',
                    'visible' => true,
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
    'init' => function () {
        app('API')->search->register(function ($text) {
            return \Milax\Mconsole\Pages\Models\Page::where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($page) {
                return [
                    'type' => 'page',
                    'text' => sprintf('%s', $page->slug),
                    'link' => sprintf('/mconsole/pages/%s/edit', $page->id),
                ];
            });
        });
    },
];
