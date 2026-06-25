<?php

use Livewire\Component;

new class extends Component {
    // Render method
    public function render()
    {
        return $this->view()->layout('layouts::dashboard')->title('Alpine js');
    }
};
?>
<div class="max-w-7xl mx-auto py-10">
    <!-- Header -->
    <div x-data="{ message: 'Belajar Alpine.js' }" class="rounded-xl p-6">
        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-bold" x-text="message"></h1>
            <x-heroicon-s-bolt class="w-5 h-5 text-yellow-500" />
        </div>
        <p class="mt-2">Penggunaan alpine.js dalam laravel</p>
    </div>

    <!-- Counter -->
    <div x-data="{ count: 0 }" class="rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Counter</h2>

        <div class="text-4xl font-bold mb-6">
            <span x-text="count"></span>
        </div>

        <div class="flex gap-3">
            <button @click="count++" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                Increment
            </button>

            <button @click="count = 0"
                class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition">
                Reset
            </button>

            <button @click="count--" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                Decrement
            </button>
        </div>
    </div>

    <!-- Search -->
    <div x-data="{
        search: '',
        items: ['foo', 'bar', 'baz'],
    
        get filteredItems() {
            return this.items.filter((item) =>
                item.toLowerCase().includes(this.search.toLowerCase()),
            );
        },
    }" class="rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Search Filter</h2>

        <input x-model="search" type="text" placeholder="Cari item..."
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-gray-200/20 focus:outline-none" />

        <ul class="mt-4 space-y-2">
            <template x-for="item in filteredItems" :key="item">
                <li class="px-4 py-2 rounded-lg" x-text="item"></li>
            </template>

            <template x-if="filteredItems.length === 0">
                <li class="italic">Tidak ada hasil ditemukan</li>
            </template>
        </ul>
    </div>

    <!-- Toggle -->
    <div x-data="{ open: false, toggle() { this.open = !this.open } }" class="rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Toggle Content</h2>

        <button @click="toggle" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition">
            <span x-text="open ? 'Sembunyikan' : 'Tampilkan'"></span>
        </button>

        <div x-show="open" x-transition class="mt-4 p-4 rounded-lg">
            Content berhasil ditampilkan!
        </div>
    </div>

    {{-- Fecthing data --}}
    <div x-data="{ pokemon: null }" class="rounded-xl p-6" x-init="fetch('https://pokeapi.co/api/v2/pokemon/ditto')
        .then((res) => res.json())
        .then((data) => console.log(data))">
        <h2 class="text-xl font-semibold mb-4">Fetching Data</h2>

        <p>Lihat di console untuk melihat data</p>
    </div>
</div>

</div>
