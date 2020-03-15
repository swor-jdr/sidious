<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::get('me', 'AuthController@me');
});

Route::resource('users', 'UsersController', ["except" => ["create", "edit"]]);
