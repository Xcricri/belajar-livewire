<?php

use Livewire\Component;
use App\Models\Page;

new class extends Component {
    // Render method
    public function render()
    {
        return $this->view(["pages" => Page::all()]);
    }
};
?>

<div class="sticky top-0 z-50">
    {{-- Desktop header --}}
    <flux:header
        container
        class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700"
    >
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:brand
            href="#"
            logo="https://livewire.laravel.com/img/livewire-mascot.svg"
            name="Livewire"
            class="max-lg:hidden dark:hidden"
        />
        <flux:brand
            href="#"
            logo="https://livewire.laravel.com/img/livewire-mascot.svg"
            name="Livewire"
            class="max-lg:hidden! hidden dark:flex"
        />
        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item href="/#hero">Home</flux:navbar.item>
            <flux:navbar.item href="/#about">About</flux:navbar.item>
            <flux:navbar.item href="/#post">Post</flux:navbar.item>
            <flux:separator vertical variant="subtle" class="my-2" />
            <flux:dropdown class="max-lg:hidden">
                <flux:navbar.item icon:trailing="chevron-down">
                    Pages</flux:navbar.item
                >
                <flux:navmenu>
                    @foreach ($pages as $page)
                        <flux:navmenu.item
                            href="{{ url('pages/' . $page->slug) }}"
                            wire:navigate
                        >
                            {{ $page->title }}
                        </flux:navmenu.item>
                    @endforeach
                </flux:navmenu>
            </flux:dropdown>
        </flux:navbar>
        <flux:spacer />

        @guest
            <flux:button
                href="{{ route('login') }}"
                variant="primary"
                color="zinc"
                >Login</flux:button
            >
        @endguest

        @auth
            <flux:dropdown position="top" align="start">
                <flux:profile avatar="{{ auth()->user()->avatar_url }}" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.item
                            href="{{ route('dashboard') }}"
                            wire:navigate
                        >
                            Dashboard
                        </flux:menu.item>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="w-full"
                    >
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer hover:text-red-400"
                            data-test="logout-button"
                        >
                            {{ __("Log out") }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:header>

    {{-- Mobile menu --}}
    <flux:sidebar
        sticky
        collapsible="mobile"
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
    >
        <flux:sidebar.header>
            <flux:sidebar.brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="Acme Inc."
            />
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2"
            />
        </flux:sidebar.header>
        <flux:sidebar.nav>
            <flux:sidebar.item href="/#home">Home</flux:sidebar.item>
            <flux:sidebar.item href="/#about">About</flux:sidebar.item>
            <flux:sidebar.item href="/#post">Post</flux:sidebar.item>
            <flux:sidebar.group expandable heading="Pages" class="grid">
                @foreach ($pages as $page)
                    <flux:sidebar.item
                        href="{{ url('pages/' . $page->slug) }}"
                        wire:navigate
                    >
                        {{ $page->title }}
                    </flux:sidebar.item>
                @endforeach
            </flux:sidebar.group>
        </flux:sidebar.nav>
        <flux:sidebar.spacer />
    </flux:sidebar>
</div>
