<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\PostsForm;

use App\Models\Post;

new class extends Component {
    use WithFileUploads;

    public PostsForm $form;

    public function mount(Post $post)
    {
        $this->form->title = $post->title;
        $this->form->content = $post->content;
    }

    public function update()
    {
        $this->form->validate();

        // if upload new image, replace image
        if ($this->form->image) {
            // Delete old image
            Storage::disk('public')->delete('posts/' . $this->post->image);

            // Store image
            $this->form->image->storeAs('posts', $this->form->image->hashName(), 'public');

            // Get image name
            $imageName = $this->form->image->hashName();
        } else {
            $imageName = $this->post->image;
        }

        // Update Post
        $this->post->update([
            'image' => $imageName,
            'title' => $this->form->title,
            'content' => $this->form->content,
        ]);

        // Flash message
        session()->flash('message', 'Post updated successfully.');

        return redirect()->route('posts.index');
    }
};
?>

<div>
    <form wire:submit.prevent="update" class="space-y-6" enctype="multipart/form-data">

        {{-- Image --}}
        <div>
            <flux:label>Image</flux:label>
            <flux:input type="file" wire:model="form.image" class="mt-2" />
            @error('form.image')
                <flux:error class="mt-2">
                    {{ $message }}
                </flux:error>
            @enderror

            @if ($form->image)
                <div class="mt-3">
                    <img src="{{ asset('/storage/posts/' . $form->image) }}" class="h-40 rounded-lg object-cover">
                </div>
            @endif
        </div>

        {{-- Title --}}
        <div>
            <flux:label>Title</flux:label>
            <flux:input type="text" wire:model="form.title" placeholder="Enter post title" class="mt-2" />
            @error('form.title')
                <flux:error class="mt-2">
                    {{ $message }}
                </flux:error>
            @enderror
        </div>

        {{-- Content --}}
        <div>
            <flux:label>Content</flux:label>
            <flux:textarea wire:model="form.content" rows="5" placeholder="Write your content here..."
                class="mt-2" />
            @error('form.content')
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
            <flux:button as="a" href="/posts/index" wire:navigate variant="ghost">
                Back
            </flux:button>
        </div>

    </form>
</div>
