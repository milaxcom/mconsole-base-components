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
                    'translation' => 'pages.menu.form.name',
                    'url' => 'pages/create',
                    'description' => 'pages.menu.form.description',
                    'route' => 'mconsole.pages.store',
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
];
