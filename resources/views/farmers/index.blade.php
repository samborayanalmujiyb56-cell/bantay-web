@extends('layouts.app')

@section('title', 'Farmers & Farms')
@section('subtitle', 'Registered farmers and their farm profiles')

@section('content')
    @if ($farmers->isEmpty())
        <div class="rounded-xl border border-bantay-100 bg-white p-8 text-center">
            <p class="text-sm text-bantay-500">No registered farmers yet.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-bantay-100 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-bantay-100 bg-bantay-50">
                    <tr>
                        <th class="px-5 py-3 font-medium text-bantay-600">Name</th>
                        <th class="px-5 py-3 font-medium text-bantay-600">Contact</th>
                        <th class="px-5 py-3 font-medium text-bantay-600">Farms</th>
                        <th class="px-5 py-3 font-medium text-bantay-600">Reports</th>
                        <th class="px-5 py-3 font-medium text-bantay-600">Joined</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bantay-50">
                    @foreach ($farmers as $farmer)
                        <tr class="hover:bg-bantay-50/50">
                            <td class="px-5 py-4">
                                <p class="font-medium text-bantay-900">{{ $farmer->first_name }} {{ $farmer->last_name }}</p>
                                <p class="text-xs text-bantay-500">{{ $farmer->email }}</p>
                            </td>
                            <td class="px-5 py-4 text-bantay-700">{{ $farmer->contact_no ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-bantay-100 px-2.5 py-1 text-xs font-medium text-bantay-700">
                                    {{ $farmer->farms_count }} farm{{ $farmer->farms_count === 1 ? '' : 's' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                    {{ $farmer->disease_reports_count }} report{{ $farmer->disease_reports_count === 1 ? '' : 's' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-bantay-500">{{ $farmer->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('farmers.show', $farmer) }}" class="text-sm font-medium text-bantay-600 hover:underline">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $farmers->links() }}
        </div>
    @endif
@endsection