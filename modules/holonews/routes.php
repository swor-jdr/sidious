<?php
Route::get('posts', 'PostsController@all')->name('posts.list');
Route::get('posts/{slug}', 'PostsController@show')->name('posts.show');
