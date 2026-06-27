<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<footer
    class="w-full bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 md:flex md:items-center md:justify-between gap-4">

        <span class="text-sm text-zinc-500 dark:text-zinc-400 sm:text-center block md:inline">
            &copy; {{ date('Y') }} <span
                class="font-semibold text-zinc-900 dark:text-zinc-200">{{ config('app.name', 'Laravel') }}</span>. Hak
            Cipta Dilindungi.
        </span>

    </div>
</footer>
