<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div id="about">
    <flux:main container class="m-6 rounded-xl bg-zinc-50 dark:bg-zinc-900">
        <div class="space-y-8">
            <div class="space-y-3">
                <flux:heading size="xl" level="1"> About </flux:heading>

                <flux:text class="text-zinc-600 dark:text-zinc-400 leading-6">
                    Web ini merupakan dokumentasi pembelajaran Livewire, berisi
                    proses belajar dan implementasi dalam membangun aplikasi web
                    modern.
                </flux:text>
            </div>

            <div class="space-y-3">
                <flux:text>
                    Hasil implementasi selama
                    <strong class="text-zinc-700 dark:text-zinc-300"
                        >5 hari:</strong
                    >
                </flux:text>

                <ul class="space-y-3 text-zinc-700 dark:text-zinc-300 text-sm">
                    <li class="flex items-center gap-2.5">
                        <span>1. Management User</span>
                        <flux:icon.user class="size-4 text-zinc-400" />
                    </li>

                    <li class="flex items-center gap-2.5">
                        <span>2. Page Builder</span>
                        <flux:icon.newspaper class="size-4 text-zinc-400" />
                    </li>

                    <li class="flex items-center gap-2.5">
                        <span>3. Category System</span>
                        <flux:icon.list-bullet class="size-4 text-zinc-400" />
                    </li>

                    <li class="flex items-center gap-2.5">
                        <span>4. Post Publishing</span>
                        <flux:icon.squares-2x2 class="size-4 text-zinc-400" />
                    </li>
                </ul>
            </div>
        </div>
    </flux:main>
</div>
