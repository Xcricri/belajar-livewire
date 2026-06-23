<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

use App\Models\User;

new class extends Component {
    use WithFileUploads;

    public User $user;

    #[Validate("required|string|max:255")]
    public $name;

    #[Validate("required|email|max:255")]
    public $email;

    #[Validate("nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048")]
    public $avatar;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function update()
    {
        $this->validate();

        $avatarName = null;

        // Handle Avatar Upload
        if ($this->avatar) {
            // Delete existing avatar if it exists
            if ($this->user->avatar) {
                Storage::disk("public")->delete(
                    "avatars/" . $this->user->avatar,
                );
            }

            $manager = ImageManager::usingDriver(Driver::class);

            $image = $manager->decodePath($this->avatar->getRealPath());

            $webpEncoded = $image->encodeUsingFormat(Format::WEBP, quality: 80);

            $avatarName =
                "avatars/" .
                pathinfo($this->avatar->hashName(), PATHINFO_FILENAME) .
                ".webp";

            Storage::disk("public")->put($avatarName, $webpEncoded);
        } else {
            $avatarName = $this->user->avatar;
        }

        // Edit user
        $this->user->update([
            "name" => $this->name,
            "email" => $this->email,
            "avatar" => $avatarName,
        ]);

        // Flash message
        session()->flash("message", "User berhasil diupdate.");

        // Redirect
        return redirect()->route("users.index");
    }

    public function render()
    {
        return $this->view()->layout("layouts::dashboard")->title("Edit User");
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
                <flux:heading size="xl" level="1">Edit User</flux:heading>
                <flux:subheading class="mt-1"
                    >Update informasi user</flux:subheading
                >
            </div>
        </div>

        <form wire:submit="update" class="space-y-6">
            {{-- Grid Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Left column: Avatar Management --}}
                <div
                    class="lg:col-span-4 flex flex-col items-center justify-center p-4 border border-zinc-100 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-900/30"
                >
                    <flux:field
                        class="w-full flex flex-col items-center text-center"
                    >
                        <flux:label class="mb-3 self-start"
                            >Profile Avatar</flux:label
                        >

                        {{-- Avatar Circular Preview --}}
                        <div
                            class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 mb-4 shadow-sm group"
                        >
                            <div
                                wire:loading
                                wire:target="avatar"
                                class="absolute inset-0 bg-white/70 dark:bg-zinc-900/70 backdrop-blur-xs flex items-center justify-center z-20"
                            >
                                <span
                                    class="text-[10px] font-medium text-zinc-600 dark:text-zinc-400"
                                    >Mengunggah...</span
                                >
                            </div>

                            @if ($avatar)
                                {{-- New Image Preview --}}
                                <img
                                    src="{{ $avatar->temporaryUrl() }}"
                                    class="w-full h-full object-cover"
                                />
                            @elseif ($user->avatar)
                                {{-- Existing Image --}}
                                <img
                                    src="{{ asset('storage/' . $user->avatar) }}"
                                    class="w-full h-full object-cover"
                                />
                            @else
                                {{-- Placeholder --}}
                                <div
                                    class="w-full h-full flex items-center justify-center text-zinc-400 dark:text-zinc-600"
                                >
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Input File Trigger --}}
                        <div
                            class="relative flex items-center justify-center px-4 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer group text-xs font-medium"
                        >
                            <input
                                type="file"
                                wire:model="avatar"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            />
                            <span class="text-zinc-600 dark:text-zinc-400"
                                >Ganti Avatar</span
                            >
                        </div>

                        <flux:error name="avatar" class="mt-2" />
                    </flux:field>
                </div>

                {{-- Right column: User Form Data --}}
                <div class="lg:col-span-8 space-y-4">
                    {{-- Name --}}
                    <flux:field>
                        <flux:label>Nama Lengkap</flux:label>
                        <flux:input
                            type="text"
                            wire:model="name"
                            placeholder="John Doe"
                        />
                        <flux:error name="name" />
                    </flux:field>

                    {{-- Email --}}
                    <flux:field>
                        <flux:label>Alamat Email</flux:label>
                        <flux:input
                            type="email"
                            wire:model="email"
                            placeholder="johndoe@example.com"
                        />
                        <flux:error name="email" />
                    </flux:field>
                </div>
            </div>

            <flux:separator variant="subtle" />

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <flux:button
                    href="{{ route('users.index') }}"
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
                    <span wire:loading.remove wire:target="update"
                        >Update User</span
                    >
                    <span wire:loading wire:target="update">Mengupdate...</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
