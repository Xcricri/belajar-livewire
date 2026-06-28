<?php

use Livewire\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;

    // Mount method
    public function mount($id)
    {
        $this->post = Post::with(["category"])
            ->where("id", $id)
            ->firstOrFail();
    }

    // Render method
    public function render()
    {
        return $this->view([
            "post" => $this->post,
        ])
            ->layout("layouts::app")
            ->title("Post Detail");
    }
};
?>

<div>
    <livewire:view.navbar />

    <main class="max-w-7xl px-6 py-12 mx-auto">
        <div class="mb-8">
            <flux:button icon="arrow-left" wire:navigate href="/">
                Kembali ke Beranda
            </flux:button>
        </div>

        <div class="mb-8">
            <flux:heading
                size="xl"
                class="bg-zinc-50 dark:bg-zinc-900 p-6 rounded-xl"
            >
                {{ $post->title }}
                <flux:text class="mt-2 text-sm text-zinc-500">
                    Dipublikasikan oleh
                    <span class="text-zinc-400">{{
                        $post->user
                            ?->name
                    }}</span>
                </flux:text>
            </flux:heading>
        </div>

        @if ($post->image)
            <div
                class="overflow-hidden mb-8 rounded-xl bg-zinc-50 dark:bg-zinc-900 p-2"
            >
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="object-cover w-full rounded-xl h-96 sm:h-112.5"
                />
            </div>
        @endif

        <div
            class="p-6 sm:p-10 rounded-xl bg-zinc-50 dark:bg-zinc-900 relative overflow-hidden"
        >
            <flux:text> {{ $post->content }} </flux:text>
        </div>
    </main>

    <livewire:view.footer />
</div>
