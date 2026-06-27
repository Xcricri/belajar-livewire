<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section
    class="relative overflow-hidden p-8 md:p-12 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/60 bg-linear-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-900/40 transition-colors duration-200">

    <div
        class="absolute -top-24 -right-24 w-72 h-72 bg-red-500/10 dark:bg-red-500/5 rounded-full blur-3xl pointer-events-none">
    </div>
    <div
        class="absolute -bottom-24 -left-24 w-72 h-72 bg-red-600/5 dark:bg-red-600/2 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="relative z-10 max-w-2xl">

        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-zinc-900 dark:text-white mb-3">
            Belajar Laravel <span
                class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-500 dark:from-red-500 dark:to-red-400">Livewire</span>
        </h1>

        <p class="text-base leading-relaxed text-zinc-600 dark:text-zinc-400">
            Implementasi modern pengembangan aplikasi web full-stack menggunakan
            <span
                class="font-semibold text-zinc-900 dark:text-zinc-200 border-b border-zinc-300 dark:border-zinc-700 pb-0.5">Laravel
                13</span>
            &
            <span
                class="font-semibold text-zinc-900 dark:text-zinc-200 border-b border-zinc-300 dark:border-zinc-700 pb-0.5">Livewire
                v4</span>.
        </p>
    </div>
</section>
