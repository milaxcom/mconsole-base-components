<?php

namespace Milax\Mconsole\News;

use Milax\Mconsole\Contracts\ModuleInstaller;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Models\MconsoleUploadPreset;

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
    ];
    
    public static $presets = [
        [
            'key' => 'news',
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
        
        foreach (self::$presets as $preset) {
            if (MconsoleUploadPreset::where('key', $preset['key'])->count() == 0) {
                MconsoleUploadPreset::create($preset);
            }
        }
    }
    
    public static function uninstall()
    {
        app('API')->options->uninstall(self::$options);
        
        foreach (self::$presets as $preset) {
            MconsoleUploadPreset::where('key', $preset['key'])->delete();
        }
    }
}
