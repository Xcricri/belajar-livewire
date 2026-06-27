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

<div>
    @if (Route::has('login'))
        <nav x-data="{ openMobile: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <div class="shrink-0">
                    <a href="/" class="text-xl font-bold ">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-4">

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-zinc-50/10 transition-all">
                            <span>Posts</span>
                            <svg class="w-4 h-4 text-slate-500 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 bg-white dark:bg-[#3d3d3d] rounded-xl shadow-xl py-2 z-50 max-h-60 overflow-y-auto">
                            @forelse ($posts as $post)
                                <a href="{{ route('post.view', $post->id) }}"
                                    class="block px-4 py-2.5 text-sm hover:bg-zinc-50/10 dark:hover:bg-indigo-50/10 text-slate-700 dark:text-zinc-300  transition-colors">
                                    {{ $post->title }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-slate-400 dark:text-zinc-500 italic">Belum ada
                                    post</span>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-[#4d4d4d] transition-all">
                            <span>Pages</span>
                            <svg class="w-4 h-4 text-slate-500 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 bg-white dark:bg-[#3d3d3d] border border-slate-200 dark:border-zinc-800 rounded-xl shadow-xl py-2 z-50">
                            @forelse ($pages as $page)
                                <a href="{{ route('page.view', $page->slug) }}"
                                    class="block px-4 py-2.5 text-sm hover:bg-zinc-50/10 dark:hover:bg-indigo-50/10 text-slate-700 dark:text-zinc-300 transition-colors">
                                    {{ $page->title }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-slate-400 dark:text-zinc-500 italic">Belum ada
                                    halaman</span>
                            @endforelse
                        </div>
                    </div>

                    <span class="h-5 w-px bg-slate-200 dark:bg-zinc-800 mx-1"></span>

                    @auth
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold shadow-sm">
                                <span>{{ Auth::user()->name ?? 'Akun Saya' }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute right-0 mt-2 w-52 bg-[#3d3d3d] border border-slate-200 dark:border-zinc-800 rounded-xl shadow-xl py-2 z-50">
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-50/10">Dashboard</a>
                                <hr class="border-slate-200 dark:border-zinc-800 my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-red-500 font-medium hover:bg-red-50 dark:hover:bg-red-950/20">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold  transition-colors">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all shadow-sm shadow-indigo-500/20">Register</a>
                        @endif
                    @endauth
                </div>

                <div class="flex md:hidden">
                    <button @click="openMobile = !openMobile"
                        class="p-2 rounded-xl text-slate-600 dark:text-zinc-400 hover:bg-slate-100 dark:hover:bg-zinc-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="openMobile ? 'hidden' : 'inline-flex'" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="openMobile ? 'inline-flex' : 'hidden'" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    @endif

    {{-- Mobile Menu --}}
    <div x-show="openMobile" x-transition
        class="md:hidden border-t border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-4 space-y-4 shadow-inner">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-500 mb-2">Posts</div>
            <div class="pl-3 space-y-2 border-l border-slate-200 dark:border-zinc-800">
                @foreach ($posts as $post)
                    <a href="{{ route('post.view', $post->id) }}"
                        class="block text-sm text-slate-600 dark:text-zinc-400 hover:text-indigo-500">{{ $post->title }}</a>
                @endforeach
            </div>
        </div>

        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-500 mb-2">Pages</div>
            <div class="pl-3 space-y-2 border-l border-slate-200 dark:border-zinc-800">
                @foreach ($pages as $page)
                    <a href="{{ route('page.view', $page->slug) }}"
                        class="block text-sm text-slate-600 dark:text-zinc-400 ">{{ $page->title }}</a>
                @endforeach
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 dark:border-zinc-800 flex flex-col gap-2">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full text-center py-2.5 text-sm font-semibold border border-slate-200 dark:border-zinc-800 rounded-xl">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2.5 text-sm font-semibold bg-slate-100 dark:bg-zinc-800 rounded-xl">Log
                    in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="w-full text-center py-2.5 text-sm font-semibold text-white rounded-xl">Register</a>
                @endif
            @endauth
        </div>
    </div>
</div>
