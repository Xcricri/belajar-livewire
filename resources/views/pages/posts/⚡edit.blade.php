<?php

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    public Post $post;

    #[Validate('nullable|image|max:2048')]
    public $image;

    #[Validate('required')]
    public $title;

    #[Validate('required')]
    public $content;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);

        // Set default value from database
        $this->title = $this->post->title;
        $this->content = $this->post->content;
    }

    public function update()
    {
        $this->validate();

        // if upload new image, replace image
        if ($this->image) {
            // Delete old image
            Storage::disk('public')->delete('posts/' . $this->post->image);

            // Store image
            $this->image->storeAs('posts', $this->image->hashName(), 'public');

            // Get image name
            $imageName = $this->image->hashName();
        } else {
            $imageName = $this->post->image;
        }

        // Update image
        $this->post->update([
            'image' => $imageName,
            'title' => $this->title,
            'content' => $this->content,
        ]);

        // Flash message
        session()->flash('message', 'Post updated successfully.');

        return redirect()->route('posts.index');
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

        <form wire:submit.prevent="update" class="space-y-6" enctype="multipart/form-data">

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
                        <img src="{{ asset('/storage/posts/' . $post->image) }}"
                            class="h-40 rounded-lg object-cover border">
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
                    Update Post
                </flux:button>

                <flux:button as="a" href="/" wire:navigate variant="ghost">
                    Back
                </flux:button>

            </div>

        </form>

    </flux:card>

</div>
