<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-zinc-900 dark:text-zinc-100">

    {{-- Left column --}}
    <div
        class="lg:col-span-1 p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between transition-colors duration-200">
        <div>
            <h2 class="text-lg font-bold mb-5 flex items-center gap-2.5 text-zinc-900 dark:text-white">
                <x-heroicon-o-clipboard-document-check class="w-5 h-5 text-red-500 dark:text-red-400" />
                Fitur Utama (CRUD)
            </h2>
            <ul class="space-y-3.5">
                @foreach (['User Management', 'Page Builder', 'Category System', 'Post Publishing'] as $index => $fitur)
                    <li class="flex items-center gap-3 group">
                        <span
                            class="shrink-0 w-6 h-6 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-bold text-xs flex items-center justify-center group-hover:bg-red-500/10 group-hover:text-red-500 dark:group-hover:text-red-400 transition-colors">
                            {{ $index + 1 }}
                        </span>
                        <span
                            class="text-sm font-medium text-zinc-600 dark:text-zinc-300 transition-colors group-hover:text-zinc-900 dark:group-hover:text-white">
                            {{ $fitur }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Right column --}}
    <div
        class="lg:col-span-2 p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm transition-colors duration-200">
        <div class="mb-5">
            <h2 class="text-lg font-bold flex items-center gap-2.5 text-zinc-900 dark:text-white mb-0.5">
                <x-heroicon-o-server class="w-5 h-5 text-red-500 dark:text-red-400" />
                Arsitektur Relasi Basis Data
            </h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Visualisasi relasi sistem 1-to-Many (One to Many)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Left content --}}
            <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800/60">
                <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-3">Relasi
                    Page</div>
                <div
                    class="flex items-center justify-between p-3 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200/60 dark:border-zinc-800 shadow-xs">
                    <div class="text-center px-2">
                        <span class="block font-bold text-sm text-zinc-800 dark:text-zinc-200">User</span>
                        <span class="text-[10px] font-bold text-red-500 dark:text-red-400 uppercase">1 (HasMany)</span>
                    </div>
                    <div class="grow flex items-center justify-center px-2 text-zinc-400 dark:text-zinc-600">
                        <x-heroicon-o-arrow-right class="w-5 h-5" />
                    </div>
                    <div class="text-center px-2">
                        <span class="block font-bold text-sm text-zinc-800 dark:text-zinc-200">Page</span>
                        <span class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase">N
                            (BelongsTo)</span>
                    </div>
                </div>
                <p class="text-xs mt-3 text-zinc-500 dark:text-zinc-400 italic leading-relaxed">
                    "Satu pengguna dapat membuat banyak halaman statis."
                </p>
            </div>

            {{-- Right content --}}
            <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800/60">
                <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-3">Relasi
                    Post</div>
                <div
                    class="flex items-center justify-between p-3 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200/60 dark:border-zinc-800 shadow-xs">
                    <div class="text-center px-2">
                        <span class="block font-bold text-sm text-zinc-800 dark:text-zinc-200">Category</span>
                        <span class="text-[10px] font-bold text-red-500 dark:text-red-400 uppercase">1 (HasMany)</span>
                    </div>
                    <div class="grow flex items-center justify-center px-2 text-zinc-400 dark:text-zinc-600">
                        <x-heroicon-o-arrow-right class="w-5 h-5" />
                    </div>
                    <div class="text-center px-2">
                        <span class="block font-bold text-sm text-zinc-800 dark:text-zinc-200">Post</span>
                        <span class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase">N
                            (BelongsTo)</span>
                    </div>
                </div>
                <p class="text-xs mt-3 text-zinc-500 dark:text-zinc-400 italic leading-relaxed">
                    "Satu kategori menampung banyak artikel/pos blog."
                </p>
            </div>

        </div>
    </div>
</section>
