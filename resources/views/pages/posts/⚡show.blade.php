<?php

use Livewire\Component;
use App\Models\Post;

new class extends Component {
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return $this->view([
            "post" => Post::findOrFail($this->id),
        ])
            ->layout("layouts::app")
            ->title("Post Detail");
    }
};
?>

<div>
    <flux:card>
        <flux:heading>Post Details</flux:heading>

        <p>{{ $post->title }}</p>
        <p>{{ $post->content }}</p>
    </flux:card>
</div>
