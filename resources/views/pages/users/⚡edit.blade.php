<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

new class extends Component {
    use WithFileUploads;

    public User $user;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email')]
    public $email;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
    }

    public function store()
    {
        // Validate name
        $this->validate();

        // if upload new avatar, replace avatar
        if ($this->avatar) {
            // Delete old avatar
            Storage::disk('public')->delete('avatars/' . $this->user->avatar);

            // Store avatar
            $this->avatar->storeAs('avatars', $this->avatar->hashName(), 'public');

            $avatarName = $this->avatar->hashName();
        } else {
            $avatarName = $this->user->avatar;
        }

        // Edit user
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $avatarName,
        ]);

        // Flash message
        session()->flash('message', 'User updated successfully.');

        // Redirect
        return redirect()->route('users.index');
    }

    public function render()
    {
        return $this->view()->layout('layouts::app')->title('Edit User');
    }
};
?>

<div>
    <div class="max-w-full mx-auto py-10">
        <flux:card class="p-6">
            <flux:heading size="lg" class="mb-6">
                Edit User
            </flux:heading>


            <form wire:submit.prevent="store" class="space-y-6" enctype="multipart/form-data">

                {{-- Name --}}
                <div>
                    <flux:label>Name</flux:label>

                    <flux:input type="text" wire:model="name" placeholder="Enter user name" class="mt-2" />

                    @error('name')
                        <flux:error class="mt-2">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <flux:label>Email</flux:label>

                    <flux:input type="email" wire:model="email" placeholder="Enter user email" class="mt-2" />

                    @error('email')
                        <flux:error class="mt-2">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <flux:label>Password</flux:label>

                    <flux:input type="password" wire:model="password" placeholder="Enter user password"
                        class="mt-2" />

                    @error('password')
                        <flux:error class="mt-2">
                            {{ $message }}
                        </flux:error>
                    @enderror
                </div>

                {{-- Avatar --}}
                <div>
                    <flux:label>Avatar</flux:label>

                    <flux:input type="file" wire:model="avatar" class="mt-2" />

                    @error('avatar')
                        <flux:error class="mt-2">
                            {{ $message }}
                        </flux:error>
                    @enderror

                    @if ($avatar)
                        <div class="mt-3">
                            <img src="{{ asset('storage/avatars/' . $avatar->hashName()) }}"
                                class="h-40 rounded-lg object-cover">
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-4">

                    <flux:button type="submit" variant="primary">
                        Save User
                    </flux:button>

                    <flux:button as="a" href="/users" wire:navigate variant="ghost">
                        Back
                    </flux:button>

                </div>

            </form>
        </flux:card>
    </div>
</div>
