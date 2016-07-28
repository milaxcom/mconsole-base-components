<?php

namespace Milax\Mconsole\News;

use Milax\Mconsole\Contracts\Modules\ModuleInstaller;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Models\MconsoleUploadPreset;

class Installer implements ModuleInstaller
{
    public static $options = [
        [
            'group' => 'mconsole::news.settings.group.name',
            'label' => 'mconsole::news.settings.index',
            'key' => 'news_index_count',
            'value' => 3,
            'type' => 'text',
            'rules' => ['required', 'integer'],
            'options' => null,
        ],
        [
            'group' => 'mconsole::news.settings.group.name',
            'label' => 'mconsole::news.settings.archive',
            'key' => 'news_archive_count',
            'value' => 6,
            'type' => 'text',
            'rules' => ['required', 'integer'],
            'options' => null,
        ],
        [
            'group' => 'mconsole::news.settings.group.name',
            'label' => 'mconsole::news.settings.gallery',
            'key' => 'news_has_gallery',
            'value' => 1,
            'type' => 'select',
            'rules' => null,
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
        [
            'group' => 'mconsole::news.settings.group.name',
            'label' => 'mconsole::news.settings.cover',
            'key' => 'news_has_cover',
            'value' => 1,
            'type' => 'select',
            'rules' => null,
            'options' => ['1' => 'mconsole::settings.options.on', '0' => 'mconsole::settings.options.off'],
        ],
    ];
    
    public static $presets = [
        [
            'key' => 'news_cover',
            'type' => MX_UPLOAD_TYPE_IMAGE,
            'name' => 'News cover',
            'path' => 'news-cover',
            'extensions' => ['jpg', 'jpeg', 'png'],
            'min_width' => 200,
            'min_height' => 100,
            'operations' => [
                [
                    'operation' => 'resize',
                    'type' => 'ratio',
                    'width' => '200',
                    'height' => '100',
                ],
                [
                    'operation' => 'save',
                    'path' => 'cover',
                    'quality' => '',
                ],
                [
                    'operation' => 'resize',
                    'type' => 'center',
                    'width' => '90',
                    'height' => '90',
                ],
                [
                    'operation' => 'save',
                    'path' => 'preview',
                    'quality' => '',
                ],
            ],
        ],
        [
            'key' => 'news',
            'type' => MX_UPLOAD_TYPE_IMAGE,
            'name' => 'News',
            'path' => 'news',
            'extensions' => ['jpg', 'jpeg', 'png'],
            'min_width' => 800,
            'min_height' => 600,
            'operations' => [
                [
                    'operation' => 'resize',
                    'type' => 'ratio',
                    'width' => '800',
                    'height' => '600',
                ],
                [
                    'operation' => 'save',
                    'path' => 'gallery',
                    'quality' => '',
                ],
                [
                    'operation' => 'resize',
                    'type' => 'center',
                    'width' => '90',
                    'height' => '90',
                ],
                [
                    'operation' => 'save',
                    'path' => 'preview',
                    'quality' => '',
                ],
            ],
        ],
    ];
    
    public static function install()
    {
        app('API')->options->install(self::$options);
        app('API')->presets->install(self::$presets);
    }
    
    public static function uninstall()
    {
        app('API')->options->uninstall(self::$options);
        app('API')->presets->uninstall(self::$presets);
        
        $repository = new \Milax\Mconsole\News\NewsRepository(\Milax\Mconsole\News\Models\News::class);
        foreach ($repository->get() as $instance) {
            $instance->delete();
        }
    }
}
