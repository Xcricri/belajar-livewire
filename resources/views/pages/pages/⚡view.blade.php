<?php

use Livewire\Component;
use App\Models\Page;

new class extends Component {
    public Page $page;

    // Mount method
    public function mount($slug)
    {
        $this->page = Page::with(['user'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return $this->view([
            'page' => $this->page,
        ])
            ->layout('layouts::app')
            ->title($this->page->title);
    }
};

?>

<div class="min-h-screen bg-[#0b0b0c] text-zinc-200">
    <livewire:welcome.navbar />

    <main class="max-w-5xl px-6 py-12 mx-auto">
        <div class="mb-8">
            <flux:button variant="ghost" icon="arrow-left" wire:navigate href="/"
                class="text-zinc-400 hover:text-white hover:bg-zinc-900 border border-transparent hover:border-zinc-800 transition-all duration-200">
                Kembali ke Beranda
            </flux:button>
        </div>

        <div class="mb-8">
            <flux:heading size="xl" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                {{ $page->title }}<span class="text-[#ff2d20]">.</span>
            </flux:heading>
            <p class="mt-2 text-sm text-zinc-500">
                Dipublikasikan oleh <span class="text-zinc-400">{{ $page->user?->name }}</span>
            </p>
        </div>

        @if ($page->image)
            <div class="overflow-hidden mb-8 rounded-2xl border border-zinc-800/60 bg-[#121214] p-2 shadow-2xl">
                <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}"
                    class="object-cover w-full rounded-xl h-96 sm:h-112.5" />
            </div>
        @endif

        <div class="p-6 sm:p-10 rounded-2xl border border-zinc-800/80 bg-[#121214] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div
                class="prose max-w-none prose-invert prose-zinc
                prose-headings:text-white
                prose-headings:font-bold
                prose-p:text-zinc-300
                prose-p:leading-relaxed
                prose-a:text-[#ff2d20] hover:prose-a:text-red-400
                prose-strong:text-white
                prose-code:text-red-400 prose-code:bg-zinc-900 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded">

                {{ $page->content }}

            </div>
        </div>
    </main>

    <livewire:welcome.footer />
</div>
