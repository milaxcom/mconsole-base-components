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
                    'translation' => 'menu.pages.list.name',
                    'url' => 'pages',
                    'description' => 'menu.pages.list.description',
                    'route' => 'mconsole.pages.index',
                    'visible' => true,
                    'enabled' => true,
                ],
                'pages_form' => [
                    'name' => 'Create page',
                    'translation' => 'menu.pages.form.name',
                    'url' => 'pages/create',
                    'description' => 'menu.pages.form.description',
                    'route' => 'mconsole.pages.store',
                    'visible' => true,
                    'enabled' => true,
                ],
                'pages_update' => [
                    'name' => 'Edit pages',
                    'translation' => 'menu.pages.update.name',
                    'description' => 'menu.pages.update.description',
                    'route' => 'mconsole.pages.edit',
                    'visible' => false,
                    'enabled' => true,
                ],
                'pages_delete' => [
                    'name' => 'Delete pages',
                    'translation' => 'menu.pages.delete.name',
                    'description' => 'menu.pages.delete.description',
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
