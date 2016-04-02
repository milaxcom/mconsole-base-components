<?php

return [
    'name' => 'Pages',
    'identifier' => 'mconsole-pages',
    'menu' => [],
    'register' => [
        'middleware' => [],
        'providers' => [],
        'aliases' => [],
        'bindings' => [],
        'dependencies' => [],
    ],
    'config' => [],
    'translations' => [],
    'views' => [],
    'relationships' => [
        'ContentLink' => [
            'links' => function ($self) {
                return $self->hasMany('Milax\Mconsole\Models\ContentLink', 'page_id');
            },
        ],
    ],
];
