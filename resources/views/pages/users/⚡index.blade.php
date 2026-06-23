<?php

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

new class extends Component {
    use WithPagination;

    #[url(history: true)]
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Delete function
    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && file_exists(storage_path('app/public/users/' . $user->avatar))) {
            unlink(storage_path('app/public/users/' . $user->avatar));
        }

        // Delete data
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
    }

    // Render function
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return $this->view([
            'users' => $users,
        ])
            ->layout('layouts::app')
            ->title('Users List');
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
                    Users List
                </flux:heading>
                <p class="text-sm">
                    Kelola semua user Anda di satu tempat
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <flux:input class="w-full sm:w-72" placeholder="Cari user..." wire:model.live.debounce.500ms="search" />

                <flux:button as="a" href="/users/create" variant="primary" wire:navigate>
                    Buat User
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
                    <flux:table.column>Avatar</flux:table.column>
                    <flux:table.column>Nama</flux:table.column>
                    <flux:table.column>Email</flux:table.column>
                    <flux:table.column class="text-center w-40">
                        Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($users as $item)
                        <flux:table.row class="align-middle hover:bg-gray-100/10 transition">
                            <flux:table.cell>
                                {{ $loop->iteration }}
                            </flux:table.cell>

                            {{-- Image --}}
                            <flux:table.cell>
                                <img src="{{ asset('/storage/' . $item->avatar) }}" alt="{{ $item->name }}"
                                    class="h-12 w-12 rounded-full object-cover" />
                            </flux:table.cell>

                            {{-- Name --}}
                            <flux:table.cell class="font-semibold text-gray-900">
                                {{ $item->name }}
                            </flux:table.cell>

                            {{-- Email --}}
                            <flux:table.cell class="text-gray-600">
                                {{ $item->email }}
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    <flux:button as="a" href="/users/edit/{{ $item->id }}" size="sm"
                                        wire:navigate>
                                        Edit
                                    </flux:button>

                                    <flux:button size="sm" variant="danger" x-data
                                        x-on:click.prevent="
                                            if (confirm('Yakin ingin menghapus user ini?')) {
                                                $wire.delete({{ $item->id }})
                                            }
                                        ">
                                        Hapus
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
                                        Belum ada user yang dibuat
                                    </div>

                                    <flux:button as="a" href="/users/create" size="sm" variant="primary"
                                        wire:navigate>
                                        + Buat User Pertama
                                    </flux:button>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-end">{{ $users->links() }}</div>
    </flux:card>
</div>
