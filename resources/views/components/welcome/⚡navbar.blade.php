<?php

use Livewire\Component;
use App\Models\Post;
use App\Models\Page;

new class extends Component {
    public $posts;
    public $pages;

    public function mount()
    {
        $this->posts = Post::latest()->take(5)->get();
        $this->pages = Page::all();
    }
};
?>

<div x-data="{ openMobile: false }"
    class="w-full bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 transition-colors duration-200">
    @if (Route::has('login'))
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <div class="shrink-0">
                    <a href="/"
                        class="text-xl font-black tracking-tight text-zinc-900 dark:text-white flex items-center gap-2">
                        <span class="text-red-500">Belajar</span><span>livewire</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-2">
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-300 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all">
                            <span>Posts</span>
                            <x-heroicon-o-chevron-down class="w-4 h-4 text-zinc-400 transition-transform duration-200"
                                x-bind:class="open ? 'rotate-180 text-red-500' : ''" />
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-60 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/60 rounded-xl shadow-lg shadow-zinc-200/50 dark:shadow-none py-1.5 z-50 max-h-60 overflow-y-auto"
                            style="display: none;">
                            @forelse ($posts as $post)
                                <a href="{{ route('post.view', $post->id) }}"
                                    class="block px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                    {{ $post->title }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-zinc-400 dark:text-zinc-500 italic">Belum ada
                                    post</span>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-300 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all">
                            <span>Pages</span>
                            <x-heroicon-o-chevron-down class="w-4 h-4 text-zinc-400 transition-transform duration-200"
                                x-bind:class="open ? 'rotate-180 text-red-500' : ''" />
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-60 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/60 rounded-xl shadow-lg shadow-zinc-200/50 dark:shadow-none py-1.5 z-50"
                            style="display: none;">
                            @forelse ($pages as $page)
                                <a href="{{ route('page.view', $page->slug) }}"
                                    class="block px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                    {{ $page->title }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-zinc-400 dark:text-zinc-500 italic">Belum ada
                                    halaman</span>
                            @endforelse
                        </div>
                    </div>

                    <span class="h-5 w-px bg-zinc-200 dark:bg-zinc-800 mx-2"></span>

                    @auth
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all">
                                <span>{{ Auth::user()->name ?? 'Akun Saya' }}</span>
                                <x-heroicon-o-chevron-down class="w-4 h-4 text-zinc-400" />
                            </button>
                            <div x-show="open" x-transition
                                class="absolute right-0 mt-2 w-52 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/60 rounded-xl shadow-lg shadow-zinc-200/50 dark:shadow-none py-1.5 z-50"
                                style="display: none;">
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                    Dashboard
                                </a>
                                <hr class="border-zinc-100 dark:border-zinc-700/50 my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 rounded-xl transition-all shadow-sm shadow-red-600/10">
                            Log in
                        </a>
                    @endauth
                </div>

                <div class="flex md:hidden">
                    <button @click="openMobile = !openMobile"
                        class="p-2 rounded-xl text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <x-heroicon-o-bars-3 x-show="!openMobile" class="w-6 h-6" />
                        <x-heroicon-o-x-mark x-show="openMobile" class="w-6 h-6" style="display: none;" />
                    </button>
                </div>
            </div>
        </nav>
    @endif

    <div x-show="openMobile" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 px-4 py-4 space-y-4"
        style="display: none;">

        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-2 px-3">Posts
            </div>
            <div class="space-y-1">
                @forelse ($posts as $post)
                    <a href="{{ route('post.view', $post->id) }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                        {{ $post->title }}
                    </a>
                @empty
                    <span class="block px-3 py-2 text-sm text-zinc-400 dark:text-zinc-500 italic">Belum ada post</span>
                @endforelse
            </div>
        </div>

        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-2 px-3">Pages
            </div>
            <div class="space-y-1">
                @forelse ($pages as $page)
                    <a href="{{ route('page.view', $page->slug) }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                        {{ $page->title }}
                    </a>
                @empty
                    <span class="block px-3 py-2 text-sm text-zinc-400 dark:text-zinc-500 italic">Belum ada
                        halaman</span>
                @endforelse
            </div>
        </div>

        <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col gap-2">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full text-center py-2.5 text-sm font-semibold text-zinc-700 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full text-center py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 rounded-xl transition-colors">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2.5 text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-xl transition-colors">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="w-full text-center py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-500 rounded-xl transition-colors shadow-sm">
                        Register
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>
