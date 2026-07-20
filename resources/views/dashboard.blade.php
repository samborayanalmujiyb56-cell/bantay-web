@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Overview of farm health and reports')

@section('content')
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-bantay-100">
                    <x-icon name="users" class="w-5 h-5 text-bantay-600" />
                </div>
                <p class="text-sm text-bantay-500">Registered Farmers</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">{{ $totalFarmers }}</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-bantay-100">
                    <x-icon name="leaf" class="w-5 h-5 text-bantay-600" />
                </div>
                <p class="text-sm text-bantay-500">Registered Farms</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">{{ $totalFarms }}</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50">
                    <x-icon name="megaphone" class="w-5 h-5 text-red-500" />
                </div>
                <p class="text-sm text-bantay-500">Total Disease Reports</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">{{ $totalReports }}</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-50">
                    <x-icon name="chart" class="w-5 h-5 text-yellow-600" />
                </div>
                <p class="text-sm text-bantay-500">Pending Validations</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">{{ $pendingCount }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-bantay-800">Disease Cases Over Time</h3>
            <canvas id="trendChart" height="200"></canvas>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-bantay-800">Reports by Disease Type</h3>
            <canvas id="diseaseChart" height="200"></canvas>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-bantay-800">Report Status Breakdown</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-bantay-800">Top Affected Barangays</h3>
            <canvas id="barangayChart" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const trendData = @json($reportsByMonth);
        const diseaseData = @json($reportsByDisease);
        const statusData = @json($reportsByStatus);
        const barangayData = @json($topBarangays);

        const green = '#2e7d32';
        const palette = ['#2e7d32', '#ef6c00', '#c62828', '#f9a825', '#616161'];

        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: Object.keys(trendData),
                datasets: [{
                    label: 'Reports',
                    data: Object.values(trendData),
                    borderColor: green,
                    backgroundColor: 'rgba(46,125,50,0.1)',
                    fill: true,
                    tension: 0.3,
                }],
            },
            options: { plugins: { legend: { display: false } } },
        });

        new Chart(document.getElementById('diseaseChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(diseaseData).map(d => d.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())),
                datasets: [{ data: Object.values(diseaseData), backgroundColor: palette }],
            },
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [{ data: Object.values(statusData), backgroundColor: palette }],
            },
            options: { plugins: { legend: { display: false } } },
        });

        new Chart(document.getElementById('barangayChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(barangayData),
                datasets: [{ data: Object.values(barangayData), backgroundColor: green }],
            },
            options: { indexAxis: 'y', plugins: { legend: { display: false } } },
        });
    </script>
@endsection