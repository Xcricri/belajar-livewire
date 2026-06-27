<?php

use Livewire\Component;
use App\Models\Page;

new class extends Component {
    public Page $page;

    // Mount method
    public function mount($slug)
    {
        $this->page = Page::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return $this->view([
            'page' => $this->page,
        ])
            ->layout('layouts::app')
            ->title('Page Detail');
    }
};

?>


<div class="max-w-5xl px-6 py-12 mx-auto">
    <div class="mb-8">
        <flux:heading size="xl" class="font-bold">
            {{ $page->title }}
        </flux:heading>
    </div>

    @if ($page->image)
        <flux:card class="p-0 overflow-hidden mb-8">
            <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}"
                class="object-cover w-full h-112.5" />
        </flux:card>
    @endif

    <flux:card>
        <div class="prose max-w-none dark:prose-invert text-black dark:text-white">
            {{ $page->content }}
        </div>
    </flux:card>

    <div class="mt-8">
        <flux:button variant="filled" icon="arrow-left" wire:navigate href="/">
            Kembali
        </flux:button>
    </div>
</div>
