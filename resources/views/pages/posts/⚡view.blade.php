<?php

use Livewire\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;

    public $title;

    public $content;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function render()
    {
        return $this->view([
            'post' => $this->post,
        ])
            ->layout('layouts::app')
            ->title('Post Detail');
    }
};
?>

<div class="max-w-5xl px-6 py-12 mx-auto">
    <div class="mb-8">
        <flux:heading size="xl" class="font-bold">
            {{ $post->title }}
        </flux:heading>
    </div>

    @if ($post->image)
        <flux:card class="p-0 overflow-hidden mb-8">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                class="object-cover w-full h-112.5" />
        </flux:card>
    @endif

    <flux:card>
        <div class="prose max-w-none dark:prose-invert text-black dark:text-white">
            {{ $post->content }}
        </div>
    </flux:card>

    <div class="mt-8">
        <flux:button variant="filled" icon="arrow-left" wire:navigate href="/">
            Back to Posts
        </flux:button>
    </div>
</div>
