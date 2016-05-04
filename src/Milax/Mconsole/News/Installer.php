<?php

namespace Milax\Mconsole\News;

use Milax\Mconsole\Contracts\Modules\ModuleInstaller;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\News\NewsRepository;
use Milax\Mconsole\News\Models\News;

class Installer implements ModuleInstaller
{
    public static $options = [
        [
            'group' => 'news.settings.group.name',
            'label' => 'news.settings.index',
            'key' => 'news_index_count',
            'value' => 3,
            'type' => 'text',
            'rules' => ['required', 'integer'],
        ],
        [
            'group' => 'news.settings.group.name',
            'label' => 'news.settings.archive',
            'key' => 'news_archive_count',
            'value' => 6,
            'type' => 'text',
            'rules' => ['required', 'integer'],
        ],
        [
            'group' => 'news.settings.group.name',
            'label' => 'news.settings.gallery',
            'key' => 'news_has_gallery',
            'value' => 1,
            'type' => 'select',
            'options' => ['1' => 'settings.options.on', '0' => 'settings.options.off'],
        ],
        [
            'group' => 'news.settings.group.name',
            'label' => 'news.settings.cover',
            'key' => 'news_has_cover',
            'value' => 1,
            'type' => 'select',
            'options' => ['1' => 'settings.options.on', '0' => 'settings.options.off'],
        ],
    ];
    
    public static $presets = [
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
        
        $repository = new NewsRepository(News::class);
        foreach ($repository->get() as $instance) {
            $instance->delete();
        }
    }
}
