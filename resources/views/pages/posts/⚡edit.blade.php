<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

new class extends Component {
    use WithFileUploads;

    public Post $post;

    #[Validate("nullable|image|max:2048")]
    public $image;

    #[Validate("required")]
    public $title;

    #[Validate("required")]
    public $content;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);

        // set default value from database
        $this->title = $this->post->title;
        $this->content = $this->post->content;
    }

    public function update()
    {
        $this->validate();

        $imageName = null;

        // if upload new image, replace image
        if ($this->image) {
            // delete old image
            Storage::disk("public")->delete("posts/" . $this->post->image);

            $manager = ImageManager::usingDriver(Driver::class);

            $image = $manager->decodePath($this->image->getRealPath());

            $webpEncoded = $image->encodeUsingFormat(Format::WEBP, quality: 80);

            $imageName =
                "posts/" .
                pathinfo($this->image->hashName(), PATHINFO_FILENAME) .
                ".webp";

            Storage::disk("public")->put($imageName, $webpEncoded);
        } else {
            $imageName = $this->post->image;
        }

        // update to database
        $this->post->update([
            "image" => $imageName,
            "title" => $this->title,
            "content" => $this->content,
        ]);

        session()->flash("message", "Post berhasil diperbarui.");

        return redirect()->route("posts.index");
    }

    public function render()
    {
        return $this->view()->layout("layouts::app")->title("Edit Post");
    }
};
?>

<div class="max-w-7xl mx-auto py-10">
    <flux:card
        class="space-y-6 shadow-sm border border-zinc-200/50 dark:border-zinc-800/50"
    >
        {{-- Header --}}
        <div
            class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-4"
        >
            <div>
                <flux:heading size="xl" level="1">Edit Post</flux:heading>
                <flux:subheading class="mt-1"
                    >Perbarui detail informasi dan media untuk artikel
                    ini.</flux:subheading
                >
            </div>
        </div>

        <form wire:submit="update" class="space-y-6">
            {{-- Grid Layout: 1 Kolom di Mobile, 2 Kolom di Desktop --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Kolom Kiri: Image Management --}}
                <div class="lg:col-span-5 space-y-4">
                    <flux:field>
                        <flux:label>Cover Image</flux:label>

                        {{-- Image Display Area --}}
                        <div
                            class="relative rounded-lg overflow-hidden border border-zinc-200/80 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 group aspect-video lg:h-48 w-full mb-3"
                        >
                            {{-- Loading Overlay ketika sedang upload gambar baru --}}
                            <div
                                wire:loading
                                wire:target="image"
                                class="absolute inset-0 bg-white/70 dark:bg-zinc-900/70 backdrop-blur-sm flex items-center justify-center z-20"
                            >
                                <span
                                    class="text-sm font-medium text-zinc-600 dark:text-zinc-400"
                                    >Mengunggah Gamba Baru...</span
                                >
                            </div>

                            @if ($image)
                                {{-- Preview Gambar Baru --}}
                                <img
                                    src="{{ $image->temporaryUrl() }}"
                                    alt="New Preview"
                                    class="w-full h-full object-cover"
                                />
                            @else
                                {{-- Gambar Lama dari Database --}}
                                <img
                                    src="{{ asset('storage/posts/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover"
                                />
                            @endif
                        </div>

                        {{-- Modern File Input Trigger --}}
                        <div
                            class="relative flex items-center justify-center w-full border border-zinc-200 dark:border-zinc-800 rounded-lg p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition cursor-pointer group"
                        >
                            <input
                                type="file"
                                wire:model="image"
                                id="image-upload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            />
                            <div
                                class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400"
                            >
                                <flux:icon.document-arrow-up
                                    class="h-4 w-4 text-zinc-400 group-hover:text-zinc-500"
                                />
                                <span>Ganti gambar baru (opsional)</span>
                            </div>
                        </div>

                        <flux:error name="image" />
                    </flux:field>
                </div>

                {{-- Kolom Kanan: Form Inputs --}}
                <div class="lg:col-span-7 space-y-4">
                    {{-- Title --}}
                    <flux:field>
                        <flux:label>Title</flux:label>
                        <flux:input
                            wire:model="title"
                            placeholder="Masukkan judul post..."
                            clearable
                        />
                        <flux:error name="title" />
                    </flux:field>

                    {{-- Content --}}
                    <flux:field>
                        <flux:label>Content</flux:label>
                        <flux:textarea
                            wire:model="content"
                            rows="9"
                            placeholder="Tulis isi artikel..."
                            resize="none"
                        />
                        <flux:error name="content" />
                    </flux:field>
                </div>
            </div>

            <flux:separator variant="subtle" />

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <flux:button
                    href="{{ route('posts.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    Cancel
                </flux:button>

                <flux:button
                    type="submit"
                    variant="primary"
                    wire:loading.attr="disabled"
                    class="min-w-25"
                >
                    <span wire:loading.remove wire:target="update"
                        >Update Post</span
                    >
                    <span wire:loading wire:target="update">Mengupdate...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
