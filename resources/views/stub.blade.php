@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-bantay-600">{{ $title }} — coming in {{ $phase }}.</p>
    </div>
@endsection