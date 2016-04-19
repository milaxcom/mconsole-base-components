<?php

return [
    'module' => [
        'description' => 'Управление новостями',
    ],
    'menu' => [
        'list' => [
            'name' => 'Новости',
            'description' => 'Отображать список новостей',
        ],
        'create' => [
            'name' => 'Добавить новость',
            'description' => 'Добавить запись в новостную ленту',
        ],
        'update' => [
            'name' => 'Редактировать новость',
            'description' => 'Обновлении информации в добавленных новостях',
        ],
        'delete' => [
            'name' => 'Удалить новость',
            'description' => 'Удаление записей из новостной ленты',
        ],
    ],
    'table' => [
        'published' => 'Добавлено',
        'updated' => 'Обновлено',
        'slug' => 'Адрес',
        'heading' => 'Заголовок',
    ],
    'form' => [
        'indexing' => 'Индексация для поисковых систем',
        'date' => 'Дата',
        'heading' => 'Заголовок',
        'slug' => 'Адрес',
        'preview' => 'Превью',
        'text' => 'HTML',
        'title' => 'Заголовок для поиска',
        'description' => 'Описание страницы',
        'gallery' => 'Изображения',
    ],
    'settings' => [
        'index' => 'Количество новостей на главной',
        'archive' => 'Количество новостей в архиве',
        'gallery' => 'Поддержка галлереи',
        'group' => [
            'name' => 'Новости',
        ],
    ],
];
