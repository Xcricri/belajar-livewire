<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include ("partials.head")
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 font-sans">
    {{-- Navigation --}}
    <livewire:view.navbar />

    {{-- Main content --}}

    {{-- Hero --}}
    <livewire:view.hero />

    {{-- About --}}
    <livewire:view.about />

    {{-- Post --}}
    <livewire:view.post />

    {{-- Footer --}}
    <livewire:view.footer />

    @livewireScripts
    @fluxScripts
</body>
</html>
