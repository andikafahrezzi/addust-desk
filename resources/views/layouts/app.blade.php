<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AddustDesk')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased bg-canvas text-slate-900">

<div class="min-h-screen flex">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        {{-- Topbar --}}
        <header class="h-16 shrink-0 border-b border-border bg-white flex items-center justify-between px-6">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 leading-tight">
                    @yield('page-title', 'Dashboard')
                </h1>
                @hasSection('page-subtitle')
                    <p class="text-sm text-slate-500">@yield('page-subtitle')</p>
                @endif
            </div>

            <div class="flex items-center gap-4">
                @hasSection('page-actions')
                    <div class="flex items-center gap-2">
                        @yield('page-actions')
                    </div>
                    <div class="w-px h-6 bg-border"></div>
                @endif

                <div class="w-8 h-8 rounded-full bg-accent text-white text-sm font-medium flex items-center justify-center">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-6">
            <div class="max-w-6xl mx-auto space-y-4">

                @if (session('success'))
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>