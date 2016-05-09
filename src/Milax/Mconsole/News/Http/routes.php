<?php

Route::group([
    'prefix' => config('mconsole.url'),
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\News\Http\Controllers',
], function () {
    
    Route::resource('/news', 'NewsController');
    
});
