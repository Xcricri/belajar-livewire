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
    <h1 class="text-2xl font-bold" x-data="{ message: 'i love livewire' }" x-text="message"></h1>

    <h2 class="text-base">Count: {{ $count }}</h2>
    <button wire:click="increment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Increment
    </button>
    <button wire:click="decrement" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        Decrement
    </button>
    <button wire:click="resetcount" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Reset
    </button>

    <div class="" x-data="{
        search: '',
    
        item: ['foo', 'bar', 'baz'],
    
        get filteredItem() {
            return this.item.filter(
                i => i.startsWith(this.search)
            )
        }
    }">
        <input x-model="search" type="text" placeholder="Search...">

        <ul>
            <template x-for="item in filteredItem" :key="item">
                <li x-text="item"></li>
            </template>
        </ul>
    </div>

    <div class="" x-data="{ open: false }">
        <button @click="open = !open">Toggle</button>

        <div x-show="open">
            Content...
        </div>
    </div>
</div>
