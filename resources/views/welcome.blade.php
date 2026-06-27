<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include ('partials.head')
</head>

<body
    class="min-h-screen flex flex-col bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50 antialiased font-sans transition-colors duration-300">

    <header class="w-full bg-white dark:bg-zinc-900 sticky top-0 z-50 transition-colors duration-300">
        {{-- Navbar --}}
        <livewire:welcome.navbar />
    </header>

    <main class="grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="space-y-10 md:space-y-14">
            {{-- Hero Section --}}
            <livewire:welcome.hero />

            {{-- Grid Section --}}
            <livewire:welcome.grid />
        </div>
    </main>

    <livewire:welcome.footer />

    @livewireScripts
    @fluxScripts
</body>

</html>
