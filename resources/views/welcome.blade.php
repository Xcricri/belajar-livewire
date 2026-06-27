<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name', 'Laravel Livewire') }}</title>

    @vite (["resources/css/app.css", "resources/js/app.js"])
</head>

<body
    class="min-h-screen flex flex-col bg-white text-slate-900 dark:bg-zinc-800 dark:text-zinc-50 antialiased font-sans transition-colors duration-200">

    <header class="w-full bg-[#3d3d3d]">
        <livewire:header />
    </header>

    <main class="grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="space-y-8">

            <section
                class="p-8 bg-linear-to-br bg-[#3d3d3d] rounded-2xl border border-slate-200/10 shadow-sm relative overflow-hidden">

                <div class="relative z-10">
                    <h1 class="text-3xl font-black tracking-tight mt-3 mb-1">Belajar Laravel Livewire</h1>
                    <p class="text-sm text-slate-500 dark:text-zinc-400">Implementasi modern menggunakan <span
                            class="font-semibold text-slate-700 dark:text-zinc-300">Laravel 13</span> & <span
                            class="font-semibold text-slate-700 dark:text-zinc-300">Livewire v4</span></p>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div
                    class="lg:col-span-1 p-6 bg-[#3d3d3d] rounded-2xl border border-slate-200/10 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <x-heroicon-o-clipboard-document-check class="w-5 h-5" />
                            Fitur Utama (CRUD)
                        </h2>
                        <ul class="space-y-3">
                            @foreach (['User Management', 'Page Builder', 'Category System', 'Post Publishing'] as $index => $fitur)
                                <li class="flex items-center gap-3">
                                    <span
                                        class="shrink-0 rounded-lg font-bold flex items-center justify-center">{{ $index + 1 }}</span>
                                    <span>{{ $fitur }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-2 p-6 bg-[#3d3d3d] rounded-2xl border border-slate-200/10 shadow-sm">
                    <h2 class="text-lg font-bold mb-1 flex items-center gap-2">
                        <x-heroicon-o-server class="w-5 h-5" />
                        Arsitektur Relasi Basis Data
                    </h2>
                    <p class="text-xs mb-6">Visualisasi relasi sistem 1-to-Many (One
                        to Many)</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4">
                            <div class="text-xs font-bold uppercase tracking-wider mb-3">Relasi Page</div>
                            <div class="flex items-center justify-between p-3">
                                <div class="text-center px-2">
                                    <span class="block font-bold text-base">User</span>
                                    <span class="text-xs uppercase">1 (HasMany)</span>
                                </div>
                                <div class="grow flex items-center justify-center px-2">
                                    <x-heroicon-o-arrow-right class="w-6 h-6" />
                                </div>
                                <div class="text-center px-2">
                                    <span class="block font-bold text-base">Page</span>
                                    <span class="text-xs">N (BelongsTo)</span>
                                </div>
                            </div>
                            <p class="text-xs mt-2.5 italic">"Satu pengguna dapat
                                membuat banyak halaman statis."</p>
                        </div>

                        <div class="p-4">
                            <div class="text-xs font-bold uppercase tracking-wider mb-3">Relasi Post</div>
                            <div class="flex items-center justify-between p-3">
                                <div class="text-center px-2">
                                    <span class="block font-bold text-base">Category</span>
                                    <span class="text-xs uppercase">1 (HasMany)</span>
                                </div>
                                <div class="grow flex items-center justify-center px-2">
                                    <x-heroicon-o-arrow-right class="w-6 h-6 text-slate-400 " />
                                </div>
                                <div class="text-center px-2">
                                    <span class="block font-bold text-base">Post</span>
                                    <span class="text-xs uppercase">N (BelongsTo)</span>
                                </div>
                            </div>
                            <p class="text-xs mt-2.5 italic">"Satu kategori menampung
                                banyak artikel/pos blog."</p>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </main>



    <footer class="bg-[#3d3d3d] shadow-xs">
        <div class="w-full mx-auto max-w-7xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-body sm:text-center"> &copy; {{ date('Y') }}
                {{ config('app.name', 'Laravel') }}. Hak Cipta Dilindungi.
            </span>
        </div>
    </footer>


    @livewireScripts
    @fluxScripts
</body>

</html>
