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

    public $slug;

    #[Validate("required|string|max:255")]
    public $title = "";

    #[Validate("required|image|mimes:jpeg,png,jpg,gif,webp|max:2048")]
    public $image;

    #[Validate("nullable|string")]
    public $content = "";

    #[Validate("required|exists:users,id")]
    public $user_id = "";

    // Store method
    public function store()
    {
        $this->validate();

        if ($this->image) {
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
        }

        // Generate slug
        $created_slug = Str::slug($this->title);

        // Create page
        Page::create([
            "title" => $this->title,
            "slug" => $created_slug,
            "image" => $imagePath,
            "content" => $this->content,
            "user_id" => $this->user_id,
        ]);

        // Session flash
        session()->flash("message", "Page created successfully.");

        // Redirect
        return redirect()->route("pages.index");
    }

    // Render method
    public function render()
    {
        return $this->view([
            "users" => User::all(),
        ])
            ->layout("layouts::dashboard")
            ->title("Create Page");
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
                <flux:heading size="lg">Buat Page</flux:heading>
                <flux:subheading class="mt-1">
                    Form untuk menambahkan halaman baru beserta detailnya.
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
                    {{-- Category --}}
                    <flux:field>
                        <flux:label>Pengguna</flux:label>
                        <flux:select
                            wire:model="user_id"
                            placeholder="Pilih pengguna..."
                            clearable
                        >
                            @foreach ($users as $user)
                                <flux:select.option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="user_id" />
                    </flux:field>

                    {{-- Title --}}
                    <flux:field>
                        <flux:label>Judul</flux:label>
                        <flux:input
                            wire:model="title"
                            placeholder="Masukkan judul page..."
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
                            placeholder="Tulis isi page..."
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
                    href="{{ route('pages.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    Batal
                </flux:button>

                <flux:button
                    type="submit"
                    variant="primary"
                    wire:offline.attr="disable"
                    wire:loading.attr="disabled"
                    class="min-w-25"
                >
                    <span wire:loading.remove wire:target.enter="store"
                        >Simpan Page</span
                    >
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
