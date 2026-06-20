<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    // Rendering
    public function render()
    {
        return $this->view()->layout('layouts::app')->title('Create Post');
    }
};
?>

<div class="max-w-full mx-auto py-10">

    <flux:card class="p-6">

        <flux:heading size="lg" class="mb-6">
            Create New Post
        </flux:heading>

        <livewire:posts.create />

    </flux:card>

</div>
