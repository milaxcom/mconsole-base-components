<?php

Route::group([
    'prefix' => config('mconsole.url'),
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Pages\Http\Controllers',
], function () {
    
    Route::resource('/pages', 'PagesController');
    
});
