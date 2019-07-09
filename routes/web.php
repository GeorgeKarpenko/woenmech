<?php

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
Auth::routes();

Route::get('home', 'HomeController@index')->name('home');


Route::prefix('admin')->name('admin.')->group(function () {

    //admin
    Route::get('/', 'Admin\IndexController@index')->name('index');

    Route::get('roles', 'Admin\RolesController@index')->name('roles.index')->middleware('role:admin');
    Route::post('roles/update', 'Admin\RolesController@update')->name('roles.update')->middleware('role:admin');
    Route::get('roles/users/{id}', 'Admin\RolesController@show')->name('users.show')->middleware('role:admin');
    Route::get('roles/{user}/edit', 'Admin\RolesController@edit')->name('users.edit')->middleware('role:admin');
    Route::post('roles/{user}/update', 'Admin\RolesController@updateUser')->name('users.update')->middleware('role:admin');
    Route::get('roles/{user}/delete', 'Admin\RolesController@delete')->name('users.delete')->middleware('role:admin');

    //Route::get('{path}', 'Admin\PagesController@index')->name('articles');

    Route::get('{path}', 'Admin\PagesController@index')->name('pages.index');
    Route::get('pages/create/{path?}/{webPage?}', 'Admin\PagesController@create')->name('pages.create')->middleware('permission:sections.create');
    Route::post('pages/make/{path?}', 'Admin\PagesController@make')->name('pages.make')->middleware('permission:sections.create');
    Route::get('pages/edit/{page}/{path?}/{webPage?}', 'Admin\PagesController@edit')->name('pages.edit')->middleware('permission:sections.edit');
    Route::post('pages/update/{page}/{path?}', 'Admin\PagesController@update')->name('pages.update')->middleware('permission:sections.edit');
    Route::post('pages/priority/{path?}', 'Admin\PagesController@priority')->name('pages.priority')->middleware('permission:sections.priority');
    Route::get('pages/delete/{page}/{path?}', 'Admin\PagesController@delete')->name('pages.delete')->middleware('permission:sections.delete');

    Route::get('{path}/{article}', 'Admin\ArticlesController@index')->name('articles.index');
    Route::get('articles/{path}/create', 'Admin\ArticlesController@create')->name('articles.create')->middleware('permission:articles.create');
    Route::post('articles/{path}/make', 'Admin\ArticlesController@make')->name('articles.make')->middleware('permission:articles.create');
    Route::get('articles/{path}/{article}/edit', 'Admin\ArticlesController@edit')->name('articles.edit')->middleware('permission:articles.edit');
    Route::post('articles/{path}/{article}/update', 'Admin\ArticlesController@update')->name('articles.update')->middleware('permission:articles.edit');
    Route::post('articles/{path}/priority', 'Admin\ArticlesController@priority')->name('articles.priority')->middleware('permission:articles.priority');
    Route::get('articles/{article}/delete', 'Admin\ArticlesController@delete')->name('articles.delete')->middleware('permission:articles.delete');

    Route::get('audio/{path}/create', 'Admin\ArticlesController@audioCreate')->name('audio.create')->middleware('permission:articles.create');

});

Route::get('/', 'IndexController@index')->name('index');

Route::get(
    'search',
    array(
        'as' => 'search',
        'uses' => 'SearchController@index'
    )
);
Route::get('{path}', 'ArticlesController@index')->name('articles');
Route::get('{path}/{article}', 'ArticlesController@show')->name('article');



