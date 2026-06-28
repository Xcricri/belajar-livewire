<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div id="hero">
    <flux:main container class="m-6 rounded-xl bg-zinc-50 dark:bg-zinc-900">
        <div class="space-y-8">
            <div class="space-y-2">
                <flux:heading
                    size="xl"
                    level="1"
                    class="flex items-center gap-2"
                >
                    Belajar <span class="text-pink-500">Livewire</span>
                    <flux:brand
                        href="#"
                        logo="https://livewire.laravel.com/img/livewire-mascot.svg"
                    />
                </flux:heading>

                <flux:text class="text-zinc-600 dark:text-zinc-400">
                    Implementasi web modern menggunakan
                    <a
                        href="https://livewire.laravel.com/"
                        class="font-medium text-pink-500 hover:underline"
                    >
                        Livewire v4 </a
                    >.
                </flux:text>
            </div>
        </div>
    </flux:main>
</div>
