<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in — BANTAY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans">
    <div class="grid h-full grid-cols-1 lg:grid-cols-2">

        {{-- Left: brand panel --}}
        <div class="hidden lg:flex flex-col justify-between bg-bantay-700 p-12 text-white">
            <div class="flex items-center gap-3">
                <x-logo class="w-10 h-10" />
                <span class="text-lg font-semibold">BANTAY</span>
            </div>

            <div>
                <h2 class="text-3xl font-semibold leading-tight">
                    Early detection.<br>Faster response.<br>Healthier harvests.
                </h2>
                <p class="mt-4 max-w-sm text-sm text-bantay-100">
                    A surveillance and early-warning platform helping the Municipal
                    Agriculture Office monitor crop health and respond to disease
                    outbreaks in real time.
                </p>
            </div>

            <p class="text-xs text-bantay-200">© {{ date('Y') }} BANTAY — Capstone Project</p>
        </div>

        {{-- Right: login form --}}
        <div class="flex items-center justify-center bg-bantay-50 p-8">
            <div class="w-full max-w-sm">
                <div class="mb-8 flex flex-col items-center lg:items-start">
                    <x-logo class="mb-3 w-10 h-10 lg:hidden" />
                    <h1 class="text-xl font-semibold text-bantay-900">Welcome back</h1>
                    <p class="text-sm text-bantay-500">Log in to your MAO dashboard</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-bantay-800">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="you@example.com"
                               class="w-full rounded-lg border border-bantay-200 bg-white px-3.5 py-2.5 text-sm text-bantay-900 placeholder:text-bantay-300 focus:border-bantay-500 focus:outline-none focus:ring-2 focus:ring-bantay-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-bantay-800">Password</label>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full rounded-lg border border-bantay-200 bg-white px-3.5 py-2.5 text-sm text-bantay-900 placeholder:text-bantay-300 focus:border-bantay-500 focus:outline-none focus:ring-2 focus:ring-bantay-500/20">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-bantay-600">
                        <input type="checkbox" name="remember" class="rounded border-bantay-300 text-bantay-600 focus:ring-bantay-500">
                        Remember me
                    </label>

                    <button type="submit"
                            class="w-full rounded-lg bg-bantay-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-bantay-700 transition">
                        Log in
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-bantay-400">
                    Admin and MAO personnel access only. Farmers should use the BANTAY mobile app.
                </p>
            </div>
        </div>
    </div>
</body>
</html>