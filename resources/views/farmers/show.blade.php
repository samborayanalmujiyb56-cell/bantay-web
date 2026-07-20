@extends('layouts.app')

@section('title', $farmer->first_name . ' ' . $farmer->last_name)
@section('subtitle', 'Farmer profile, farms, and report history')

@section('content')
    <a href="{{ route('farmers.index') }}" class="mb-4 inline-block text-sm text-bantay-600 hover:underline">
        &larr; Back to Farmers & Farms
    </a>

    <div class="mb-6 rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-bantay-100 text-lg font-semibold text-bantay-700">
                {{ strtoupper(substr($farmer->first_name, 0, 1)) }}
            </div>
            <div>
                <p class="text-lg font-semibold text-bantay-900">{{ $farmer->first_name }} {{ $farmer->last_name }}</p>
                <p class="text-sm text-bantay-500">{{ $farmer->email }} &middot; {{ $farmer->contact_no ?? 'No contact number' }}</p>
            </div>
        </div>
    </div>

    <h3 class="mb-3 text-sm font-semibold text-bantay-800">Farms</h3>
    @if ($farmer->farms->isEmpty())
        <p class="mb-6 text-sm text-bantay-500">No farms registered.</p>
    @else
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ($farmer->farms as $farm)
                <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
                    <p class="font-medium text-bantay-900">{{ $farm->name }}</p>
                    <p class="text-sm text-bantay-500">{{ $farm->barangay }} &middot; {{ $farm->area_size }} hectares</p>
                    <p class="mt-2 text-xs text-bantay-400">
                        {{ $farm->productionRecords->count() }} production record{{ $farm->productionRecords->count() === 1 ? '' : 's' }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    <h3 class="mb-3 text-sm font-semibold text-bantay-800">Disease Reports</h3>
    @if ($farmer->diseaseReports->isEmpty())
        <p class="text-sm text-bantay-500">No disease reports submitted.</p>
    @else
        <div class="space-y-3">
            @foreach ($farmer->diseaseReports as $report)
                <div class="flex items-center justify-between rounded-xl border border-bantay-100 bg-white p-4 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-bantay-900">
                            {{ $report->report_type === 'ai' ? 'AI Detection' : 'Manual Report' }}
                            @if ($report->detectionResult)
                                &middot; {{ ucwords(str_replace('_', ' ', $report->detectionResult->disease)) }}
                            @elseif ($report->admin_diagnosis)
                                &middot; {{ ucwords(str_replace('_', ' ', $report->admin_diagnosis)) }}
                            @endif
                        </p>
                        <p class="text-xs text-bantay-500">{{ $report->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-medium
                        {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $report->status === 'validated' ? 'bg-bantay-100 text-bantay-700' : '' }}
                        {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
@endsection