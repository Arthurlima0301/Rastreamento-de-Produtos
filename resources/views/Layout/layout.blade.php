@props([
    'slot' => null,
])


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css'])
    @livewireStyles
    @fluxAppearance
</head>

<body class="h-screen">
    <!-- Header Component --->
    <x-header></x-header>

    <main class="flex flex-col items-center w-full p-4">
        @yield('content')

        {{ $slot }}

    </main>

    @livewireScripts
    @fluxScripts
</body>

</html>
