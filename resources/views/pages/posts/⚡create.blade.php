<?php

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    #[Validate('required|image|max:2048')]
    public $image;

    #[Validate('required')]
    public $title;

    #[Validate('required')]
    public $content;

    public function store()
    {
        // Validate method
        $this->validate();

        // Store image
        $this->image->storeAs('posts', $this->image->hashName(), 'public');

        // Get image name
        $imageName = $this->image->hashName();

        // Create
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $imageName,
        ]);

        // Flash message
        session()->flash('message', 'Post created successfully.');

        // Redirect route
        return redirect()->route('posts.index');
    }

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

        <form wire:submit.prevent="store" class="space-y-6" enctype="multipart/form-data">

            {{-- Image --}}
            <div>
                <flux:label>Image</flux:label>

                <flux:input type="file" wire:model="image" class="mt-2" />

                @error('image')
                    <flux:error class="mt-2">
                        {{ $message }}
                    </flux:error>
                @enderror

                @if ($image)
                    <div class="mt-3">
                        <img src="{{ $image->temporaryUrl() }}" class="h-40 rounded-lg object-cover border">
                    </div>
                @endif
            </div>

            {{-- Title --}}
            <div>
                <flux:label>Title</flux:label>

                <flux:input type="text" wire:model="title" placeholder="Enter post title" class="mt-2" />

                @error('title')
                    <flux:error class="mt-2">
                        {{ $message }}
                    </flux:error>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <flux:label>Content</flux:label>

                <flux:textarea wire:model="content" rows="5" placeholder="Write your content here..."
                    class="mt-2" />

                @error('content')
                    <flux:error class="mt-2">
                        {{ $message }}
                    </flux:error>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-4">

                <flux:button type="submit" variant="primary">
                    Save Post
                </flux:button>

                <flux:button as="a" href="/" wire:navigate variant="ghost">
                    Back
                </flux:button>

            </div>

        </form>

    </flux:card>

</div>
