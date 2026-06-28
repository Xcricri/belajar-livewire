<?php

use Livewire\Component;
use App\Models\Page;

new class extends Component {
    public Page $page;

    // Mount method
    public function mount($slug)
    {
        $this->page = Page::with(["user"])
            ->where("slug", $slug)
            ->firstOrFail();
    }

    // Render method
    public function render()
    {
        return $this->view([
            "page" => $this->page,
        ])
            ->layout("layouts::app")
            ->title($this->page->title);
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
                {{ $page->title }}
                <flux:text class="mt-2 text-sm text-zinc-500">
                    Dipublikasikan oleh
                    <span class="text-zinc-400">{{
                        $page->user
                            ?->name
                    }}</span>
                </flux:text>
            </flux:heading>
        </div>

        @if ($page->image)
            <div
                class="overflow-hidden mb-8 rounded-xl bg-zinc-50 dark:bg-zinc-900 p-2"
            >
                <img
                    src="{{ asset('storage/' . $page->image) }}"
                    alt="{{ $page->title }}"
                    class="object-cover w-full rounded-xl h-96 sm:h-112.5"
                />
            </div>
        @endif

        <div
            class="p-6 sm:p-10 rounded-xl bg-zinc-50 dark:bg-zinc-900 relative overflow-hidden"
        >
            <flux:text> {{ $page->content }} </flux:text>
        </div>
    </main>

    <livewire:view.footer />
</div>
