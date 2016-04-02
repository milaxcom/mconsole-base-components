<?php

Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Pages\Http\Controllers',
], function () {
    
    Route::resource('/pages', 'PagesController');
    
});
