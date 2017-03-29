<?php

return [
    'module' => 'Управление новостями',
    'quickmenu' => [
        'create' => 'Добавить новость',
    ],
    'menu' => 'Новости',
    'table' => [
        'published' => 'Добавлено',
        'updated' => 'Обновлено',
        'slug' => 'Адрес',
        'heading' => 'Заголовок',
    ],
    'form' => [
        'indexing' => 'Индексация для поисковых систем',
        'pinned' => 'Закрепить в топе',
        'published_at' => 'Дата публикации',
        'heading' => 'Заголовок',
        'slug' => 'Адрес',
        'preview' => 'Превью',
        'text' => 'HTML',
        'seo' => 'Настройки SEO',
        'title' => 'Заголовок для поиска',
        'description' => 'Описание страницы',
        'gallery' => 'Изображения',
        'cover' => 'Обложка',
    ],
    'settings' => [
        'index' => 'Количество новостей на главной',
        'archive' => 'Количество новостей в архиве',
        'gallery' => 'Поддержка галлереи',
        'cover' => 'Поддержка обложки',
        'group' => [
            'name' => 'Новости',
        ],
    ],
    'acl' => [
        'index' => 'Новости: просмотр списка',
        'create' => 'Новости: форма создания',
        'store' => 'Новости: сохранение',
        'edit' => 'Новости: форма редактирования',
        'update' => 'Новости: обновление',
        'show' => 'Новости: просмотр',
        'destroy' => 'Новости: удаление',
    ],
];
