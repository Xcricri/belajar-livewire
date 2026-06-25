<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::livewire('/posts/{id}', 'pages::posts.view')->name('post.view');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('admin/dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin/users')->name('users.')->group(function () {
        Route::livewire('/', 'pages::users.index')->name('index');
        Route::livewire('/create', 'pages::users.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::users.edit')->name('edit');
    });


    Route::prefix('admin/posts')->name('posts.')->group(function () {
        Route::livewire('/', 'pages::posts.index')->name('index');
        Route::livewire('/create', 'pages::posts.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::posts.edit')->name('edit');
    });

    Route::prefix('admin/categories')->name('categories.')->group(function () {
        Route::livewire('/', 'pages::categories.index')->name('index');
        Route::livewire('/create', 'pages::categories.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::categories.edit')->name('edit');
    });

    Route::livewire('admin/alpine', 'pages::alpine.index')->name('alpine.index');
    Route::livewire('admin/todos', 'pages::todos.index')->name('todos.index');
});


require __DIR__ . '/settings.php';
