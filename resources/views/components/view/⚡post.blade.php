<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Post;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url]
    public $search = '';

    public function render()
    {
        return $this->view([
            'posts' => Post::search($this->search)->paginate(5),
        ]);
    }
};
?>

<div id="post">
    <flux:main container class="m-6 rounded-xl bg-zinc-50 dark:bg-zinc-900">
        <div class="space-y-6">

            <!-- Header -->
            <div class="space-y-4">
                <flux:heading size="xl" level="1">
                    Posts
                </flux:heading>

                <div class="max-w-md">
                    <flux:input icon="magnifying-glass" placeholder="Search posts..." wire:model.live="search"
                        size="sm" />
                </div>
            </div>

            <!-- Grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($posts as $post)
                    <flux:card class="overflow-hidden flex flex-col h-full">

                        <!-- Image -->
                        @if ($post->image)
                            <div class="aspect-video overflow-hidden bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                                <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition hover:scale-105 duration-300">
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-5 flex flex-col flex-1 space-y-3">

                            <flux:heading size="lg" class="leading-snug">
                                {{ $post->title }}
                            </flux:heading>

                            <flux:text class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                {{ $post->content }}
                            </flux:text>

                            <!-- Spacer -->
                            <div class="mt-auto pt-4">
                                <flux:button href="{{ url('posts/' . $post->id) }}" variant="primary" size="sm"
                                    class="w-full">
                                    Read more
                                </flux:button>
                            </div>

                        </div>
                    </flux:card>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-zinc-500 dark:text-zinc-400">
                            No posts found
                        </div>
                    </div>
                @endforelse

            </div>

            <!-- Pagination (dipindah ke luar grid) -->
            <div class="flex justify-center pt-4">
                {{ $posts->links() }}
            </div>

        </div>
    </flux:main>
</div>
