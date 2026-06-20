<?php

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

use App\Models\Post;

new class extends Component {
    use WithPagination;

    // Delete function
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
        return view('pages.posts.index', [
            'posts' => Post::latest()->paginate(5),
        ]);
    }
};
?>

<div>
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
                <flux:table.column class="w-20">Number</flux:table.column>
                <flux:table.column>Image</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Content</flux:table.column>
                <flux:table.column class="text-center w-40">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($posts as $item)
                    <flux:table.row class="align-middle hover:bg-gray-100/10 transition">

                        <flux:table.cell>
                            {{ $loop->iteration }}
                        </flux:table.cell>

                        {{-- Image --}}
                        <flux:table.cell>
                            <img src="{{ asset('/storage/posts/' . $item->image) }}" alt="{{ $item->title }}"
                                class="h-12 w-12 rounded-lg object-cover">
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
                                <flux:button as="a" href="/posts/edit/{{ $item->id }}" size="sm"
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
                            <div class="flex flex-col items-center gap-3">
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
</div>
