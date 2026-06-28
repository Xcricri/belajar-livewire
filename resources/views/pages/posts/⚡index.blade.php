<?php

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use App\Models\Post;

new class extends Component {
    use WithPagination;

    #[Url(history: true)]
    public $search = "";

    #[Url]
    public $statusFilter = "active";

    #[Computed]
    public function posts()
    {
        return Post::search($this->search)
            ->query(function ($query) {
                if ($this->statusFilter === "trashed") {
                    $query->onlyTrashed();
                } elseif ($this->statusFilter === "all") {
                    $query->withTrashed();
                }
            })
            ->paginate(10);
    }

    // Soft delete
    public function softDelete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash("message", "Post berhasil dipindahkan ke sampah.");
    }

    // Force delete
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if (
            $post->image &&
            file_exists(storage_path("app/public/posts/" . $post->image))
        ) {
            unlink(storage_path("app/public/posts/" . $post->image));
        }

        // Delete data
        $post->forceDelete();

        // flash message
        session()->flash("message", "Post deleted permanently successfully.");
    }

    // Restore delete
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        session()->flash("message", "Post restored successfully.");
    }

    // Render function
    public function render()
    {
        return $this->view([
            "posts" => $this->posts,
        ])
            ->layout("layouts::dashboard")
            ->title("Post List");
    }
};
?>

<div class="max-w-7xl mx-auto py-10">
    <flux:card class="p-6 space-y-6">
        {{-- Header --}}
        <div
            class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
        >
            {{-- Title --}}
            <div>
                <flux:heading size="lg" class="font-bold">
                    Post List
                </flux:heading>
                <p class="text-sm">Kelola semua post Anda di satu tempat</p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <flux:input
                    class="w-full sm:w-72"
                    placeholder="Cari post..."
                    wire:model.live.debounce.300ms="search"
                />

                {{-- Filter Status (Soft Delete) --}}
                <select
                    wire:model.live="statusFilter"
                    class="rounded-lg border-gray-300 text-sm py-2.5 px-3 dark:bg-zinc-800 dark:border-zinc-700"
                >
                    <option value="active">Aktif</option>
                    <option value="trashed">Sampah</option>
                    <option value="all">Semua</option>
                </select>

                <flux:button
                    as="a"
                    href="/admin/posts/create"
                    variant="primary"
                    wire:navigate
                >
                    Buat Post
                </flux:button>
            </div>
        </div>

        {{-- Flash message --}}
        @if (session()->has("message"))
            <flux:callout variant="success">
                {{
                    session(
                        "message",
                    )
                }}
            </flux:callout>
        @endif

        {{-- Table card --}}
        <div class="rounded-xl overflow-hidden">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="w-20">Nomor</flux:table.column>
                    <flux:table.column>Gambar</flux:table.column>
                    <flux:table.column>Judul</flux:table.column>
                    <flux:table.column class="text-center w-48">
                        Actions</flux:table.column
                    >
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($posts as $item)
                        <flux:table.row
                            class="align-middle hover:bg-gray-100/10 transition {{ $item->trashed() ? 'bg-red-50/30 dark:bg-red-950/10' : '' }}"
                        >
                            <flux:table.cell>
                                {{ $loop->iteration }}
                            </flux:table.cell>

                            {{-- Image --}}
                            <flux:table.cell>
                                <img
                                    src="{{ asset('/storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                />
                            </flux:table.cell>

                            {{-- Title --}}
                            <flux:table.cell
                                class="font-semibold text-gray-900 dark:text-zinc-100"
                            >
                                {{ $item->title }}
                                @if ($item->trashed())
                                    <span
                                        class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded dark:bg-red-900 dark:text-red-200"
                                        >Terhapus</span
                                    >
                                @endif
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell>
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    @if ($item->trashed())
                                        {{-- Restore post --}}
                                        <flux:button
                                            size="sm"
                                            variant="ghost"
                                            wire:click="restore({{ $item->id }})"
                                        >
                                            Restore
                                        </flux:button>
                                        {{-- Force Delete (Permanent) --}}
                                        <flux:button
                                            size="sm"
                                            variant="danger"
                                            x-on:click="targetId = {{ $item->id }}; $flux.modal('confirm-force-delete').show()"
                                        >
                                            Hapus Permanen
                                        </flux:button>
                                    @else
                                        {{-- Edit post --}}
                                        <flux:button
                                            as="a"
                                            href="/admin/posts/edit/{{ $item->id }}"
                                            size="sm"
                                            wire:navigate
                                        >
                                            Edit
                                        </flux:button>
                                        <flux:button
                                            size="sm"
                                            variant="danger"
                                            x-on:click="targetId = {{ $item->id }}; $flux.modal('confirm-delete').show()"
                                        >
                                            Delete
                                        </flux:button>
                                    @endif
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        {{-- Empty state --}}
                        <flux:table.row>
                            <flux:table.cell
                                colspan="4"
                                class="py-14 text-center"
                            >
                                <div class="flex flex-col items-center gap-3">
                                    <div class="text-sm">
                                        Belum ada posts yang dibuat
                                    </div>

                                    <flux:button
                                        as="a"
                                        href="/admin/posts/create"
                                        size="sm"
                                        variant="primary"
                                        wire:navigate
                                    >
                                        + Buat Post Pertama
                                    </flux:button>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-end">{{ $posts->links() }}</div>
    </flux:card>

    {{-- Confirm Delete Modal (Soft Delete) --}}
    <flux:modal name="confirm-delete" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Pindahkan ke Sampah?</flux:heading>
                <flux:subheading>
                    Post ini akan dipindahkan ke folder sampah dan tidak muncul
                    di publik.
                </flux:subheading>
            </div>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button
                    variant="danger"
                    x-on:click="
                        $wire.softDelete(targetId);
                        $flux.modal('confirm-delete').close();
                    "
                >
                    Ya, Pindahkan
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Confirm Force Delete Modal (Permanen) --}}
    <flux:modal name="confirm-force-delete" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Permanen?</flux:heading>
                <flux:subheading>
                    Apakah Anda yakin? Tindakan ini akan menghapus data dari
                    database selamanya dan tidak bisa dikembalikan.
                </flux:subheading>
            </div>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button
                    variant="danger"
                    x-on:click="
                        $wire.forceDelete(targetId);
                        $flux.modal('confirm-force-delete').close();
                    "
                >
                    Ya, Hapus Selamanya
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
