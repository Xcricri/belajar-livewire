<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

use App\Models\Category;

new class extends Component {
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        $category = Category::query()
            ->when($this->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(5);
        return $this->view([
            'categories' => $category,
        ])
            ->layout('layouts::dashboard')
            ->title('Categories');
    }
};
?>


<div class="max-w-7xl mx-auto py-10">
    <flux:card class="p-6 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Title --}}
            <div>
                <flux:heading size="lg" class="font-bold">
                    Category List
                </flux:heading>
                <p class="text-sm">Kelola semua kategori Anda di satu tempat</p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <flux:input class="w-full sm:w-72" placeholder="Cari kategori..." wire:model.live="search" />

                <flux:button as="a" href="/admin/categories/create" variant="primary" wire:navigate>
                    Buat Kategori
                </flux:button>
            </div>
        </div>

        {{-- Flash image --}}
        @if (session()->has('message'))
            <flux:callout variant="success">
                {{ session('message') }}
            </flux:callout>
        @endif

        {{-- Table card --}}
        <div class="rounded-xl overflow-hidden">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="w-20">Nomor</flux:table.column>
                    <flux:table.column>Title</flux:table.column>
                    <flux:table.column>Description</flux:table.column>
                    <flux:table.column class="text-center w-40">
                        Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($categories as $item)
                        <flux:table.row class="align-middle hover:bg-gray-100/10 transition">
                            <flux:table.cell>
                                {{ $loop->iteration }}
                            </flux:table.cell>

                            {{-- Title --}}
                            <flux:table.cell class="font-semibold text-gray-900">
                                {{ $item->name }}
                            </flux:table.cell>

                            {{-- Description --}}
                            <flux:table.cell class="font-semibold text-gray-900">
                                {{ $item->description }}
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    <flux:button as="a" href="/admin/categories/edit/{{ $item->id }}"
                                        size="sm" wire:navigate>
                                        Edit
                                    </flux:button>

                                    <flux:button size="sm" variant="danger"
                                        x-on:click="targetId = {{ $item->id }};
                                        $flux.modal('confirm-delete').show()">
                                        Delete
                                    </flux:button>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        {{-- Empty state --}}
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="py-14 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="text-sm">
                                        Belum ada kategori yang dibuat
                                    </div>

                                    <flux:button as="a" href="/admin/categories/create" size="sm"
                                        variant="primary" wire:navigate>
                                        + Buat Kategori Pertama
                                    </flux:button>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-end">{{ $categories->links() }}</div>
    </flux:card>

    {{-- Confirm Delete Modal --}}
    <flux:modal name="confirm-delete" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Kategori?</flux:heading>
                <flux:subheading>
                    Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.
                </flux:subheading>
            </div>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button variant="danger"
                    x-on:click="$wire.delete(targetId); $flux.modal('confirm-delete').close()">
                    Ya, Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
