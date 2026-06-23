<?php

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use App\Models\Post;

uses(RefreshDatabase::class);

test('create post', function () {
    Storage::fake('public');

    assertDatabaseMissing(Post::class, [
        'title' => 'Test title',
        'content' => 'Test content'
    ]);

    Livewire::test('pages::posts.create')
        ->set('title', 'Test title')
        ->set('content', 'Test content')
        ->set('image', UploadedFile::fake()->image('test.jpg'))
        ->call('store')
        ->assertHasNoErrors()
        ->assertRedirect(route('posts.index'));

    assertDatabaseHas(Post::class, [
        'title' => 'Test title',
        'content' => 'Test content'
    ]);
});
