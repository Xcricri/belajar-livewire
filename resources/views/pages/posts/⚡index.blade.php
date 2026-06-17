<?php

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // Delete method
    public function delete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && file_exists(storage_path('app/public/posts/' . $post->image))) {
            unlink(storage_path('app/public/posts/' . $post->image));
        }

        // Delete data
        $post->delete();

        // flash message
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        return $this->view([
            // Get all posts with latest pagination
            'posts' => Post::latest()->paginate(5),
        ])
            ->layout('layouts::app')
            ->title('Post List');
    }
};
?>

<div class="max-w-7xl mx-auto py-10">

    <flux:card class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <flux:heading size="lg font-bold">Post List</flux:heading>
                <div class="text-sm">
                    Manage all your posts in one place
                </div>
            </div>

            <flux:button as="a" href="/posts/create" variant="primary" wire:navigate>
                Create Post
            </flux:button>
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
                    <flux:table.column class="w-20">Image</flux:table.column>
                    <flux:table.column>Title</flux:table.column>
                    <flux:table.column>Content</flux:table.column>
                    <flux:table.column class="text-center w-40">Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($posts as $item)
                        <flux:table.row class="align-middle hover:bg-gray-100/10 transition">

                            {{-- Image --}}
                            <flux:table.cell>
                                <img src="{{ asset('/storage/posts/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="h-12 w-12 rounded-lg object-cover border">
                            </flux:table.cell>

                            {{-- Title --}}
                            <flux:table.cell class="font-semibold text-gray-900">
                                {{ $item->title }}
                            </flux:table.cell>

                            {{-- Content --}}
                            <flux:table.cell class="text-gray-600">
                                <div class="line-clamp-2">
                                    {{ Str::limit($item->content, 100) }}
                                </div>
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell>
                                <div class="flex items-center justify-center gap-2">

                                    <flux:button as="a" href="/posts/{{ $item->id }}/edit" size="sm"
                                        wire:navigate>
                                        Edit
                                    </flux:button>

                                    <flux:button size="sm" variant="danger" x-data
                                        x-on:click.prevent="
                                            if (confirm('Yakin ingin menghapus post ini?')) {
                                                $wire.delete({{ $item->id }})
                                            }
                                        ">
                                        Delete
                                    </flux:button>

                                </div>
                            </flux:table.cell>

                        </flux:table.row>
                    @empty

                        {{-- Empty state --}}
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="py-14 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-500">
                                    <div class="text-sm">
                                        Belum ada post yang dibuat
                                    </div>

                                    <flux:button as="a" href="/posts/create" size="sm" variant="primary"
                                        wire:navigate>
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
        <div class="flex justify-end">
            {{ $posts->links() }}
        </div>

    </flux:card>

</div>
