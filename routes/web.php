<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::livewire('/', 'pages::posts.index')->name('index');
        Route::livewire('/create', 'pages::posts.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::posts.edit')->name('edit');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::livewire('/', 'pages::users.index')->name('index');
        Route::livewire('/create', 'pages::users.create')->name('create');
        Route::livewire('/edit/{id}', 'pages::users.edit')->name('edit');
    });
});


require __DIR__ . '/settings.php';
