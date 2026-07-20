@extends('layouts.app')

@section('title', 'Disease Reports')
@section('subtitle', 'Review and validate farmer-submitted reports')

@section('content')
    <div class="mb-6 flex gap-2">
        @foreach (['pending' => 'Pending', 'validated' => 'Validated', 'rejected' => 'Rejected', 'all' => 'All'] as $key => $label)
            <a href="{{ route('reports.index', ['status' => $key]) }}"
               class="rounded-lg px-4 py-2 text-sm font-medium transition
                      {{ $activeStatus === $key ? 'bg-bantay-600 text-white' : 'bg-white text-bantay-600 border border-bantay-200 hover:bg-bantay-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($reports->isEmpty())
        <div class="rounded-xl border border-bantay-100 bg-white p-8 text-center">
            <p class="text-sm text-bantay-500">No {{ $activeStatus === 'all' ? '' : $activeStatus }} reports found.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($reports as $report)
                <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
                    <div class="flex gap-4">
                        <img src="{{ asset('storage/' . $report->image_path) }}"
                             alt="Report image"
                             class="h-24 w-24 flex-shrink-0 rounded-lg object-cover" />

                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-bantay-900">
                                        {{ $report->farm->name ?? 'Unknown farm' }}
                                    </p>
                                    <p class="text-sm text-bantay-500">
                                        {{ $report->user->first_name ?? 'Unknown' }} {{ $report->user->last_name ?? '' }}
                                        &middot; {{ $report->created_at->format('M d, Y g:i A') }}
                                    </p>
                                </div>

                                <span class="rounded-full px-3 py-1 text-xs font-medium
                                    {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $report->status === 'validated' ? 'bg-bantay-100 text-bantay-700' : '' }}
                                    {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>

                            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full bg-bantay-50 px-3 py-1 font-medium text-bantay-700">
                                    {{ $report->report_type === 'ai' ? 'AI Detection' : 'Manual Report' }}
                                </span>

                                @if ($report->report_type === 'ai' && $report->detectionResult)
                                    <span class="rounded-full bg-bantay-50 px-3 py-1 font-medium text-bantay-700">
                                        {{ ucwords(str_replace('_', ' ', $report->detectionResult->disease)) }}
                                    </span>
                                    <span class="rounded-full bg-bantay-50 px-3 py-1 font-medium text-bantay-700">
                                        {{ number_format($report->detectionResult->confidence * 100, 1) }}% confidence
                                    </span>
                                    <span class="rounded-full bg-bantay-50 px-3 py-1 font-medium text-bantay-700">
                                        {{ ucfirst($report->detectionResult->severity) }} severity
                                    </span>
                                @endif

                                @if ($report->admin_diagnosis)
                                    <span class="rounded-full bg-blue-50 px-3 py-1 font-medium text-blue-700">
                                        MAO diagnosis: {{ ucwords(str_replace('_', ' ', $report->admin_diagnosis)) }}
                                    </span>
                                @endif
                            </div>

                            @if ($report->report_type === 'manual' && $report->notes)
                                <div class="mt-3 rounded-lg bg-gray-50 p-3">
                                    <p class="text-xs font-medium text-bantay-500 mb-1">Farmer's observation:</p>
                                    <p class="text-sm text-bantay-700">{{ $report->notes }}</p>
                                </div>
                            @endif

                            @if ($report->admin_notes)
                                <div class="mt-2 rounded-lg bg-blue-50 p-3">
                                    <p class="text-xs font-medium text-blue-500 mb-1">MAO note:</p>
                                    <p class="text-sm text-blue-800">{{ $report->admin_notes }}</p>
                                </div>
                            @endif

                            <p class="mt-2 text-xs text-bantay-400">
                                Location: {{ $report->latitude }}, {{ $report->longitude }}
                            </p>

                            @if ($report->status === 'pending')
                                <div class="mt-4 rounded-lg border border-bantay-100 bg-bantay-50 p-4">
                                    <form method="POST" action="{{ route('reports.validate', $report) }}" class="space-y-3">
                                        @csrf

                                        @if ($report->report_type === 'manual')
                                            <div>
                                                <label class="mb-1 block text-xs font-medium text-bantay-700">
                                                    Diagnosis (required for manual reports)
                                                </label>
                                                <select name="admin_diagnosis" required
                                                        class="w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm">
                                                    <option value="">Select a diagnosis...</option>
                                                    @foreach ($diseaseOptions as $option)
                                                        <option value="{{ $option }}">{{ ucwords(str_replace('_', ' ', $option)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-bantay-700">
                                                Additional note to farmer (optional)
                                            </label>
                                            <textarea name="admin_notes" rows="2"
                                                      class="w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm"
                                                      placeholder="e.g. Please isolate the affected plant and monitor nearby trees..."></textarea>
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="submit"
                                                    class="rounded-lg bg-bantay-600 px-4 py-2 text-xs font-medium text-white hover:bg-bantay-700 transition">
                                                Validate & Notify Farmer
                                            </button>
                                        </div>
                                    </form>

                                    <form method="POST" action="{{ route('reports.reject', $report) }}" class="mt-2">
                                        @csrf
                                        <input type="text" name="admin_notes" placeholder="Reason for rejection (optional)"
                                               class="mb-2 w-full rounded-lg border border-bantay-200 px-3 py-2 text-sm" />
                                        <button type="submit"
                                                class="rounded-lg border border-red-200 bg-white px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
@endsection