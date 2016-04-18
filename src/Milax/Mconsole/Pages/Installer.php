<?php

namespace Milax\Mconsole\Pages;

use Milax\Mconsole\Contracts\ModuleInstaller;
use Milax\Mconsole\Models\MconsoleUploadPreset;

class Installer implements ModuleInstaller
{
    public static $presets = [
        [
            'key' => 'pages',
            'type' => MX_UPLOADTYPE_IMAGE,
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
        foreach (self::$presets as $preset) {
            if (MconsoleUploadPreset::where('key', $preset['key'])->count() == 0) {
                MconsoleUploadPreset::create($preset);
            }
        }
    }
    
    public static function uninstall()
    {
        foreach (self::$presets as $preset) {
            MconsoleUploadPreset::where('key', $preset['key'])->delete();
        }
    }
}
