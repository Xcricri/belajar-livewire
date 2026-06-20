<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

use App\Models\Post;

new class extends Component {
    use WithFileUploads;

    public Post $post;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);

        // Set default value from database
        $this->title = $this->post->title;
        $this->content = $this->post->content;
    }

    public function render()
    {
        return $this->view()->layout('layouts::app')->title('Edit Post');
    }
};
?>


<div class="max-w-full mx-auto py-10">

    <flux:card class="p-6">

        <flux:heading size="lg" class="mb-6">
            Edit Post
        </flux:heading>

        <livewire:posts.edit :post="$post" />

    </flux:card>

</div>
