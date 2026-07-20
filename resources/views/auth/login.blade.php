<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - BANTAY</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex h-full items-center justify-center overflow-hidden bg-bantay-50 font-sans">

    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/mao-logo.png') }}" alt=""
             class="h-full w-full object-cover opacity-20" />
    </div>
    <div class="absolute inset-0 -z-10 bg-bantay-50/50"></div>

    <div class="relative w-full max-w-sm px-6">
        <div class="mb-8 flex flex-col items-center">
            <x-logo class="mb-4 w-14 h-14" />
            <h1 class="text-xl font-semibold text-bantay-900">BANTAY</h1>
            <p class="mt-1 text-sm text-bantay-500">MAO Dashboard</p>
        </div>

        <div class="rounded-2xl bg-white/90 p-8 shadow-sm border border-bantay-100 backdrop-blur-sm">
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
                           placeholder="********"
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
        </div>

        <p class="mt-6 text-center text-xs text-bantay-400">
            Admin and MAO personnel access only. Farmers should use the BANTAY mobile app.
        </p>
    </div>
</body>
</html>