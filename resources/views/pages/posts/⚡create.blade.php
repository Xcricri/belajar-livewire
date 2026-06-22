<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    #[Validate("required|image|max:2048")]
    public $image;

    #[Validate("required")]
    public $title;

    #[Validate("required")]
    public $content;

    public function store()
    {
        $this->validate();

        // store image
        $this->image->storeAs("posts", $this->image->hashName(), "public");

        // get image name
        $imageName = $this->image->hashName();

        // insert data
        Post::create([
            "image" => $imageName,
            "title" => $this->title,
            "content" => $this->content,
        ]);

        // flash message
        session()->flash("message", "Post berhasil dibuat.");

        // redirect to index
        return redirect()->route("posts.index");
    }

    public function render()
    {
        return $this->view()->layout("layouts::app")->title("Create Post");
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
                <flux:heading size="xl" level="1">Buat Post</flux:heading>
                <flux:subheading class="mt-1"
                    >Tombol untuk menambahkan artikel baru beserta detailnya.
                </flux:subheading>
            </div>
        </div>

        <form wire:submit="store" class="space-y-6">
            {{-- Grid Layout: 1 Kolom di HP, 2 Kolom di Desktop --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Kolom Kiri: Bagian Media (Upload & Preview) --}}
                <div class="lg:col-span-5 space-y-4">
                    <flux:field>
                        <flux:label>Cover Image</flux:label>

                        <div
                            class="mt-1 relative flex items-center justify-center w-full border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-lg p-6 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition cursor-pointer group h-48"
                        >
                            <input
                                type="file"
                                wire:model="image"
                                id="image-upload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            />
                            <div class="text-center space-y-1">
                                <flux:icon.document-arrow-up
                                    class="mx-auto h-8 w-8 text-zinc-400 group-hover:text-zinc-500"
                                />
                                <div
                                    class="text-sm text-zinc-600 dark:text-zinc-400"
                                >
                                    <span
                                        class="font-medium text-indigo-600 dark:text-indigo-400"
                                        >Upload a file</span
                                    >
                                </div>
                                <p class="text-xs text-zinc-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>

                        <flux:error name="image" />
                    </flux:field>

                    {{-- Preview Image --}}
                    @if ($image)
                        <div
                            class="relative rounded-lg overflow-hidden border border-zinc-200/80 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900"
                        >
                            <div
                                wire:loading
                                wire:target="image"
                                class="absolute inset-0 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm flex items-center justify-center z-20"
                            >
                                <span
                                    class="text-sm font-medium text-zinc-600 dark:text-zinc-400"
                                    >Mengunggah...</span
                                >
                            </div>
                            <img
                                src="{{ $image->temporaryUrl() }}"
                                alt="Preview"
                                class="h-48 w-full object-cover"
                            />
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan: Bagian Teks (Title & Content) --}}
                <div class="lg:col-span-7 space-y-4">
                    {{-- Title --}}
                    <flux:field>
                        <flux:label>Judul</flux:label>
                        <flux:input
                            wire:model="title"
                            placeholder="Masukkan judul post..."
                            clearable
                        />
                        <flux:error name="title" />
                    </flux:field>

                    {{-- Content --}}
                    <flux:field>
                        <flux:label>Konten</flux:label>
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

            {{-- Actions / Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <flux:button
                    href="{{ route('posts.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    Batal
                </flux:button>

                <flux:button
                    type="submit"
                    variant="primary"
                    wire:loading.attr="disabled"
                    class="min-w-25"
                >
                    <span wire:loading.remove wire:target="store"
                        >Simpan Post</span
                    >
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
