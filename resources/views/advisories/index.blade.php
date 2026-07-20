@extends('layouts.app')

@section('title', 'Advisories')
@section('subtitle', 'Broadcast alerts and updates to all farmers')

@section('content')
    <div class="mb-6 rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-semibold text-bantay-800">Post New Advisory</h3>

        <form method="POST" action="{{ route('advisories.store') }}" class="space-y-3">
            @csrf

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="mb-1 block text-xs font-medium text-bantay-700">Category</label>
                <select name="category" class="w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm">
                    <option value="general">General</option>
                    <option value="weather">Weather Warning</option>
                    <option value="outbreak">Disease Outbreak Alert</option>
                    <option value="tip">Farming Tip</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-bantay-700">Title</label>
                <input type="text" name="title" required
                       class="w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm"
                       placeholder="e.g. Black Sigatoka outbreak reported in Barangay Malungon" />
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-bantay-700">Message</label>
                <textarea name="message" rows="4" required
                          class="w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm"
                          placeholder="Provide details and recommended actions for farmers..."></textarea>
            </div>

            <button type="submit"
                    class="rounded-lg bg-bantay-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-bantay-700 transition">
                Post Advisory
            </button>
        </form>
    </div>

    <h3 class="mb-3 text-sm font-semibold text-bantay-800">Posted Advisories</h3>

    @if ($advisories->isEmpty())
        <div class="rounded-xl border border-bantay-100 bg-white p-8 text-center">
            <p class="text-sm text-bantay-500">No advisories posted yet.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($advisories as $advisory)
                <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="mb-2 inline-block rounded-full bg-bantay-50 px-2.5 py-1 text-xs font-medium text-bantay-700">
                                {{ ucfirst($advisory->category) }}
                            </span>
                            <p class="font-semibold text-bantay-900">{{ $advisory->title }}</p>
                            <p class="mt-1 text-sm text-bantay-600">{{ $advisory->message }}</p>
                            <p class="mt-2 text-xs text-bantay-400">
                                Posted by {{ $advisory->creator->first_name ?? 'MAO' }} &middot;
                                {{ $advisory->created_at->format('M d, Y g:i A') }}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('advisories.destroy', $advisory) }}"
                              onsubmit="return confirm('Delete this advisory?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $advisories->links() }}
        </div>
    @endif
@endsection