<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdustDesk</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white p-4">

        <h2 class="text-xl font-bold mb-6">
            AdustDesk
        </h2>

        <div class="mb-4">
            <p>{{ auth()->user()->name }}</p>
            <small>
                {{ auth()->user()->role->name }}
            </small>
        </div>

        @include('layouts.sidebar')

    </aside>

    {{-- Content --}}
    <main class="flex-1 bg-gray-100 p-6">
        @yield('content')
    </main>

</div>

</body>
</html>