@extends('layouts.app')

@section('title', 'Surveillance Map')
@section('subtitle', 'Geographic distribution of reported disease cases')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="mb-4 flex flex-wrap gap-4 text-xs text-bantay-600">
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full" style="background:#c62828"></span> Severe
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full" style="background:#ef6c00"></span> Moderate
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full" style="background:#f9a825"></span> Mild
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full" style="background:#616161"></span> Manual report / Unclassified
        </div>
    </div>

    <div id="map" class="h-[600px] w-full rounded-xl border border-bantay-100 shadow-sm"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const reports = @json($reports);

        const severityColors = {
            severe: '#c62828',
            moderate: '#ef6c00',
            mild: '#f9a825',
            none: '#2e7d32',
        };

        const defaultCenter = reports.length > 0
            ? [reports[0].lat, reports[0].lng]
            : [6.8347, 125.4176]; // Sta. Cruz, Davao del Sur fallback

        const map = L.map('map').setView(defaultCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        reports.forEach((report) => {
            const color = severityColors[report.severity] || '#616161';

            const marker = L.circleMarker([report.lat, report.lng], {
                radius: 9,
                fillColor: color,
                color: '#fff',
                weight: 2,
                fillOpacity: 0.9,
            }).addTo(map);

            const diseaseLabel = report.disease
                ? report.disease.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase())
                : 'Manual report';

            const statusBadge = report.status === 'pending'
                ? '<span style="color:#b45309">Pending</span>'
                : report.status === 'validated'
                ? '<span style="color:#2e7d32">Validated</span>'
                : '<span style="color:#c62828">Rejected</span>';

            marker.bindPopup(`
                <div style="font-family: sans-serif; font-size: 13px; min-width: 180px;">
                    <strong>${report.farm}</strong><br/>
                    ${report.farmer}<br/>
                    <span style="color:#555">${diseaseLabel}</span><br/>
                    ${statusBadge} &middot; ${report.type === 'ai' ? 'AI Detection' : 'Manual'}<br/>
                    <span style="color:#999; font-size: 11px;">${report.created_at}</span>
                </div>
            `);
        });

        if (reports.length > 1) {
            const bounds = L.latLngBounds(reports.map((r) => [r.lat, r.lng]));
            map.fitBounds(bounds, { padding: [40, 40] });
        }
    </script>
@endsection