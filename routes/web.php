<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home');

// blog
Route::prefix('blog')->group(function () {
    Route::get('/', 'PostController@index')->name('post.index');

    Route::middleware(['auth'])->group(function () {
        Route::put('/posts', 'PostController@store')->name('post.put');
    });

});

// user groups
Route::prefix('user-groups')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'UserGroupController@index')->name('user-groups.index');
        Route::put('/', 'UserGroupController@store')->name('user-groups.put');
    });
});
