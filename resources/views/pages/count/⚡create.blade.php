<?php

use Livewire\Component;

new class extends Component {
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function resetcount()
    {
        $this->count = 0;
    }
};
?>

<div>
    <h1 class="text-2xl font-bold">Count: {{ $count }}</h1>
    <button
        wire:click="increment"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
    >
        Increment
    </button>
    <button
        wire:click="decrement"
        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
    >
        Decrement
    </button>
    <button
        wire:click="resetcount"
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
    >
        Reset
    </button>
</div>
