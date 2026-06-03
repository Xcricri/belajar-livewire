<?php

use Livewire\Component;

new class extends Component {
    public $title;

    public function mount($title = null)
    {
        $this->title = $title;
    }

    public function save()
    {
        dd($this->title);
    }
};
?>

<div>
    <input wire:model="title" type="text">

    <button wire:click="save">
        Save
    </button>
</div>
