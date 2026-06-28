<?php

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\Category;

new class extends Component {
    #[Validate("required|string|max:255")]
    public $name;

    #[Validate("nullable|string")]
    public $description;

    // Store method
    public function store()
    {
        $this->validate();

        Category::create([
            "name" => $this->name,
            "description" => $this->description,
        ]);

        session()->flash("message", "Category created successfully.");

        return redirect()->route("categories.index");
    }

    public function render()
    {
        return $this->view()
            ->layout("layouts::dashboard")
            ->title("Create Category");
    }
};
?>

<div class="max-w-7xl mx-auto py-10">
    <flux:card
        class="space-y-6 shadow-sm border border-zinc-200/50 dark:border-zinc-800/50"
    >
        {{-- Header --}}
        <div
            class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-4"
        >
            <div>
                <flux:heading size="lg">Create Category</flux:heading>
                <flux:subheading class="mt-1"
                    >Tambahkan kategori ke dalam aplikasi</flux:subheading
                >
                <div
                    class="p-4 mb-4 bg-red-500 text-white rounded"
                    wire:offline
                >
                    Koneksi internet Anda terputus. Beberapa fitur mungkin tidak
                    berfungsi.
                </div>
            </div>
        </div>

        <form wire:submit="store" class="space-y-6">
            <div class="lg:col-span-8 space-y-4">
                {{-- Name --}}
                <flux:field>
                    <flux:label>Name Category</flux:label>
                    <flux:input
                        type="text"
                        wire:model="name"
                        placeholder="Nama Kategori"
                    />
                    <flux:error name="name" />
                </flux:field>

                {{-- Description --}}
                <flux:field>
                    <flux:label>Description</flux:label>
                    <flux:textarea
                        wire:model="description"
                        placeholder="Deskripsi kategori"
                    />
                    <flux:error name="description" />
                </flux:field>
            </div>

            <flux:separator variant="subtle" />

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <flux:button
                    href="{{ route('categories.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    Batal
                </flux:button>

                <flux:button
                    type="submit"
                    variant="primary"
                    wire:offline.attr="disable"
                    wire:loading.attr="disabled"
                    class="min-w-25"
                >
                    <span wire:loading.remove wire:target="store"
                        >Simpan Category</span
                    >
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
