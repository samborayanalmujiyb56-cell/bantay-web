<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BANTAY') — MAO Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-bantay-50 font-sans antialiased text-bantay-900">
    <div class="flex h-full">

        {{-- Sidebar --}}
        <aside class="flex w-64 flex-col bg-white border-r border-bantay-100">
            <div class="flex items-center gap-3 px-6 py-6">
                <x-logo class="w-9 h-9" />
                <div class="leading-tight">
                    <p class="text-base font-semibold text-bantay-800">BANTAY</p>
                    <p class="text-xs text-bantay-500">MAO Dashboard</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 px-3">
                @php
                    $links = [
                        ['route' => 'dashboard', 'pattern' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                        ['route' => 'farmers.index', 'pattern' => 'farmers.*', 'icon' => 'users', 'label' => 'Farmers & Farms'],
                        ['route' => 'reports.index', 'pattern' => 'reports.*', 'icon' => 'leaf', 'label' => 'Disease Reports'],
                        ['route' => 'surveillance.map', 'pattern' => 'surveillance.*', 'icon' => 'map', 'label' => 'Surveillance Map'],
                        ['route' => 'advisories.index', 'pattern' => 'advisories.*', 'icon' => 'megaphone', 'label' => 'Advisories'],
                        
                    ];
                @endphp

                @foreach ($links as $link)
                    @php $active = request()->routeIs($link['pattern']); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                              {{ $active ? 'bg-bantay-600 text-white shadow-sm' : 'text-bantay-600 hover:bg-bantay-50 hover:text-bantay-800' }}">
                        <x-icon :name="$link['icon']" class="w-5 h-5 {{ $active ? 'text-white' : 'text-bantay-400' }}" />
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-bantay-100 px-3 py-4">
                <div class="mb-3 flex items-center gap-3 rounded-lg px-3 py-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-bantay-100 text-sm font-semibold text-bantay-700">
                        {{ strtoupper(substr(auth()->user()->first_name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-bantay-800">{{ auth()->user()->first_name ?? 'MAO Personnel' }}</p>
                        <p class="text-xs capitalize text-bantay-500">{{ auth()->user()->role ?? 'admin' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-bantay-500 hover:bg-red-50 hover:text-red-600 transition">
                        <x-icon name="logout" class="w-5 h-5" />
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex flex-1 flex-col overflow-hidden">
            <header class="flex items-center justify-between border-b border-bantay-100 bg-white px-8 py-5">
                <div>
                    <h1 class="text-xl font-semibold text-bantay-900">@yield('title', 'Dashboard')</h1>
                    <p class="text-sm text-bantay-500">@yield('subtitle', 'Municipal Agriculture Office')</p>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-bantay-50 p-8">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-bantay-200 bg-bantay-100 px-4 py-3 text-sm text-bantay-800">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>