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
            'name' => 'mconsole::pages.menu',
            'url' => 'pages',
            'visible' => true,
            'enabled' => true,
        ], 'pages', 'content');
        
        app('API')->acl->register([
            ['GET', 'pages', 'mconsole::pages.acl.index'],
            ['GET', 'pages/create', 'mconsole::pages.acl.create'],
            ['POST', 'pages', 'mconsole::pages.acl.store'],
            ['GET', 'pages/{pages}/edit', 'mconsole::pages.acl.edit'],
            ['PUT', 'pages/{pages}', 'mconsole::pages.acl.update'],
            ['GET', 'pages/{pages}', 'mconsole::pages.acl.show'],
            ['DELETE', 'pages/{pages}', 'mconsole::pages.acl.destroy'],
        ], 'pages');
        
        // Register in search engine
        app('API')->search->register(function ($text) {
            return Page::select('id', 'slug', 'heading')->where('slug', 'like', sprintf('%%%s%%', $text))->orWhere('title', 'like', sprintf('%%%s%%', $text))->orWhere('heading', 'like', sprintf('%%%s%%', $text))->orWhere('preview', 'like', sprintf('%%%s%%', $text))->orWhere('text', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($result) {
                foreach ($result->heading as $lang => $heading) {
                    if (strlen($heading) > 0) {
                        break;
                    }
                }
                return [
                    'title' => $heading,
                    'description' => str_limit(url(sprintf('/%s', $result->slug)), 45),
                    'link' => mconsole_url(sprintf('pages/%s/edit', $result->id)),
                    'tags' => ['page', sprintf('#%s', $result->id)],
                ];
            });
        });
        
        // Register in quick menu
        app('API')->quickmenu->register(function () {
            return [
                'text' => trans('mconsole::pages.quickmenu.create'),
                'link' => mconsole_url('pages/create'),
            ];
        });
    },
];
