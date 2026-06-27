<?php

use Livewire\Component;

new class extends Component {
    public $todos = []; // variable array

    public $todo = ''; // variable todo

    public $completed = []; // Variable completed

    public $editingIndex = null; // Variable edit

    // Add method
    public function add()
    {
        if ($this->todo) {
            $this->todos[] = $this->todo; // Ketika variable todo di isi, tambahkan ke array todos
            $this->reset('todo'); // Mereset variable todo
        }
    }

    // Edit method
    public function edit($index)
    {
        $this->todo = $this->todos[$index]; //Mengambil value todo berdasarkan index
        $this->editingIndex = $index; // Mengatur index yang sedang diedit
    }

    // Save method
    public function save()
    {
        //Jika index yang sedang diedit tidak null
        if ($this->editingIndex !== null) {
            $this->todos[$this->editingIndex] = $this->todo; // Mengupdate todo yang sedang diedit
            $this->reset('todo', 'editingIndex'); // Mereset variable todo dan editingIndex
        }
    }

    // Delete method
    public function delete($index)
    {
        unset($this->todos[$index]); //Menghilangkan item dari array todos
        $this->todos = array_values($this->todos); // Mengatur ulang indeks array
    }

    // Toggle method
    public function toggle($index)
    {
        $this->completed[] = $this->todos[$index]; // Menambahkan todo ke array completed

        unset($this->todos[$index]); // Menghapus todo yang sudah di toggle
    }

    // Render method
    public function render()
    {
        return $this->view([
            'todos' => $this->todos, // Mengambil value dari variable todos
            'completed' => $this->completed, // Mengambil value dari variable completed
            'editingIndex' => $this->editingIndex, // Mengambil value dari variable editingIndex
        ])
            ->layout('layouts::dashboard') //Layout dari layouts/dashboard.blade.php
            ->title('Todos'); // Nama page
    }
};
?>
<div class="max-w-7xl mx-auto p-6">
    <div class="rounded-xl shadow-md p-6 space-y-5 bg-[#3d3d3d]">

        <div>
            <h1 class="text-xl font-bold ">
                Todo List
            </h1>
        </div>

        <div class="flex gap-3">
            <input type="text" wire:model="todo" placeholder="Tambahkan todo..."
                class="flex-1 rounded-lg border border-gray-100 px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none">

            @if ($editingIndex !== null)
                <button wire:click="save"
                    class="px-3 py-1.5 text-sm bg-green-200 text-gray-800 rounded-md hover:bg-green-300 transition">Save</button>
            @else
                <button wire:click="add"
                    class="px-3 py-1.5 text-sm bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                    Tambah todo
                </button>
            @endif
        </div>

        <div class="border-t pt-4">
            <ul class="space-y-3">
                {{-- Mengambil value todos lalu di looping di dalam ul --}}
                @foreach ($todos as $todo)
                    <li wire:key="{{ $loop->index }}"
                        class="flex items-center justify-between border border-red-300 rounded-lg px-4 py-3 hover:bg-gray-100/10 transition">

                        {{ $todo }}

                        {{-- Action Buttons --}}
                        <div class="flex gap-3">
                            <button wire:click="toggle({{ $loop->index }})"
                                class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600 transition data-loading:opacity-50">
                                Completed
                            </button>
                            <button wire:click="edit({{ $loop->index }})"
                                class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition data-loading:opacity-50">
                                Edit
                            </button>
                            <button wire:click="delete({{ $loop->index }})"
                                class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600 transition data-loading:opacity-50">
                                Delete
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="border-t pt-4">
            <h2 class="text-lg mb-3">Completed Todos</h2>
            <ul class="space-y-3">
                {{-- Mengambil value completed lalu di looping di dalam ul --}}
                @foreach ($completed as $item)
                    <li wire:key="{{ $loop->index }}"
                        class="flex items-center justify-between border border-green-300 rounded-lg px-4 py-3 hover:bg-gray-100/10 transition">

                        <span class="line-through text-gray-500">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
