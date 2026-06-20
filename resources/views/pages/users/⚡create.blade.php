<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

new class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email|max:255')]
    public $email;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public function store()
    {
        // Validate method
        $this->validate();

        // Store image
        $this->avatar->storeAs('users', $this->avatar->hashName(), 'public');

        // Get image name
        $avatarName = $this->avatar->hashName();

        // Create
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $avatarName,
        ]);

        // Flash message
        session()->flash('message', 'User created successfully.');

        // Redirect route
        return redirect()->route('users.index');
    }

    // Rendering
    public function render()
    {
        return $this->view()->layout('layouts::app')->title('Create User');
    }
};
?>

<div>
    <div class="max-w-full mx-auto py-10">
        <flux:card class="p-6">
            <flux:heading size="lg" class="mb-6">
                Create New User
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
                            <img src="{{ $avatar->temporaryUrl() }}" class="h-40 rounded-lg object-cover">
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
