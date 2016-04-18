<?php

Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\News\Http\Controllers',
], function () {
    
    Route::resource('/news', 'NewsController');
    
});
