<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::livewire('/posts/{id}', 'pages::posts.view')->name('post.view');
Route::livewire('/pages/{slug}', 'pages::pages.view')->name('page.view');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('admin/dashboard', 'dashboard')->name('dashboard');

    // User route
    Route::prefix('admin/users')->name('users.')->group(function () {
        Route::livewire('/', 'pages::users.index')->name('index');
        Route::livewire('/create', 'pages::users.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::users.edit')->name('edit');
    });

    // Posts route
    Route::prefix('admin/posts')->name('posts.')->group(function () {
        Route::livewire('/', 'pages::posts.index')->name('index');
        Route::livewire('/create', 'pages::posts.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::posts.edit')->name('edit');
    });

    // Categories route
    Route::prefix('admin/categories')->name('categories.')->group(function () {
        Route::livewire('/', 'pages::categories.index')->name('index');
        Route::livewire('/create', 'pages::categories.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::categories.edit')->name('edit');
    });

    //Pages route
    Route::prefix('admin/pages')->name('pages.')->group(function () {
        Route::livewire('/', 'pages::pages.index')->name('index');
        Route::livewire('/create', 'pages::pages.create')->name('create');
        Route::livewire('/edit/{slug}', 'pages::pages.edit')->name('edit');
    });
});


require __DIR__ . '/settings.php';
