<?php

namespace Milax\Mconsole\Pages;

use Milax\Mconsole\Contracts\Modules\ModuleInstaller;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Pages\Models\Page;

class Installer implements ModuleInstaller
{
    public static $presets = [
        [
            'key' => 'pages',
            'type' => \MconsoleUploadType::Image,
            'name' => 'Pages',
            'path' => 'pages',
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
        app('API')->presets->install(self::$presets);
    }
    
    public static function uninstall()
    {
        app('API')->presets->uninstall(self::$presets);
        
        $repository = app('Milax\Mconsole\Pages\Contracts\Repositories\PagesRepository');
        foreach ($repository->get() as $instance) {
            $instance->delete();
        }
    }
}
