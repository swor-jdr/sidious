<?php
Route::get('posts', 'ArticlesController@all')->name('posts.list');
Route::get('tags', 'TagsController@index')->name('tags.list');
Route::get('posts/{slug}', 'ArticlesController@get')->name('posts.show');
