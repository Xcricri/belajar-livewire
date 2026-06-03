<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('post/{post}', 'pages::post.show');
Route::livewire('post/create', 'pages::post.create');

require __DIR__ . '/settings.php';
