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
            <p class="mt-3 text-2xl font-semibold text-bantay-900">—</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-bantay-100">
                    <x-icon name="leaf" class="w-5 h-5 text-bantay-600" />
                </div>
                <p class="text-sm text-bantay-500">Registered Farms</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">—</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50">
                    <x-icon name="megaphone" class="w-5 h-5 text-red-500" />
                </div>
                <p class="text-sm text-bantay-500">Active Disease Cases</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">—</p>
        </div>

        <div class="rounded-xl border border-bantay-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-bantay-100">
                    <x-icon name="chart" class="w-5 h-5 text-bantay-600" />
                </div>
                <p class="text-sm text-bantay-500">Pending Validations</p>
            </div>
            <p class="mt-3 text-2xl font-semibold text-bantay-900">—</p>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-bantay-100 bg-white p-6 shadow-sm">
        <p class="text-sm text-bantay-500">
            This dashboard's real numbers are wired up in Phase 9 — Reports & Analytics.
            Right now this confirms the layout, auth, and navigation work end to end.
        </p>
    </div>
@endsection