<?php

use Livewire\Component;
use App\Models\Page;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Illuminate\Support\Str;

new class extends Component {
    use WithFileUploads;

    public Page $page;

    public $slug;

    #[Validate("required|string|max:255")]
    public $title = "";

    #[Validate("nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048")]
    public $image;

    #[Validate("nullable|string")]
    public $content = "";

    #[Validate("required|exists:users,id")]
    public $user_id = "";

    // Mount method
    public function mount($slug)
    {
        $this->page = Page::where("slug", $slug)->firstOrFail();
        $this->title = $this->page->title;
        $this->content = $this->page->content;
        $this->user_id = $this->page->user_id;
    }

    // Update method
    public function update()
    {
        $this->validate();

        if ($this->image) {
            // Delete old image
            Storage::disk("public")->delete($this->page->image);

            // Initialize driver
            $manager = ImageManager::usingDriver(new Driver());

            // Decode image
            $image = $manager->decodePath($this->image->getRealPath());

            // Encode image
            $webpEncode = $image->encodeUsingFormat(Format::WEBP, quality: 80);

            // Image path
            $imagePath =
                "pages/" .
                pathinfo($this->image->getRealPath(), PATHINFO_FILENAME) .
                ".webp";

            // Save Image
            Storage::disk("public")->put($imagePath, $webpEncode);
        } else {
            $imagePath = $this->page->image;
        }

        // Generate slug
        $created_slug = Str::slug($this->title);

        $this->page->update([
            "title" => $this->title,
            "slug" => $created_slug,
            "image" => $imagePath,
            "content" => $this->content,
            "user_id" => $this->user_id,
        ]);

        session()->flash("message", "Page berhasil diperbarui.");

        return redirect()->route("pages.index");
    }

    // Render method
    public function render()
    {
        return $this->view([
            "users" => User::all(),
        ])
            ->layout("layouts::dashboard")
            ->title("Edit Page");
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
                <flux:heading size="lg">Edit Page</flux:heading>
                <flux:subheading class="mt-1">
                    Perbarui detail informasi dan media untuk halaman ini.
                </flux:subheading>
                <div
                    class="p-4 mb-4 bg-red-500 text-white rounded"
                    wire:offline
                >
                    Koneksi internet Anda terputus. Beberapa fitur mungkin tidak
                    berfungsi.
                </div>
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
                                    >Mengunggah Gambar Baru...</span
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
                                    src="{{ asset('storage/' . $page->image) }}"
                                    alt="{{ $page->title }}"
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
                    {{-- Category --}}
                    <flux:field>
                        <flux:label>Kategori</flux:label>
                        <flux:select
                            wire:model="category_id"
                            placeholder="Pilih kategori..."
                            clearable
                        >
                            @foreach ($users as $user)
                                <flux:select.option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="category_id" />
                    </flux:field>

                    {{-- Title --}}
                    <flux:field>
                        <flux:label>Title</flux:label>
                        <flux:input
                            wire:model="title"
                            placeholder="Masukkan judul page..."
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
                            placeholder="Tulis isi halaman..."
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
                    href="{{ route('pages.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    Cancel
                </flux:button>

                <flux:button
                    type="submit"
                    variant="primary"
                    wire:offline.attr="disable"
                    wire:loading.attr="disabled"
                    class="min-w-25"
                >
                    <span wire:loading.remove wire:target="update"
                        >Update Page</span
                    >
                    <span wire:loading wire:target="update">Mengupdate...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
