@extends('layouts.front')

@section('title', $ad->title . ' - Mali oglasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">{{ $ad->title }}</h1>

    <a href="{{ url()->previous() }}"
       class="text-sm px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50">
        ← Nazad
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col md:flex-row gap-6">

    {{-- Slika --}}
    <div class="md:w-1/2">
        <div class="w-full aspect-[4/3] bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center">
            @if($ad->image_path)
                <img src="{{ asset('storage/' . $ad->image_path) }}"
                     alt="{{ $ad->title }}"
                     class="w-full h-full object-cover">
            @else
                <span class="text-sm text-slate-400">Nema slike</span>
            @endif
        </div>
    </div>

    {{-- Detalji --}}
    <div class="md:w-1/2 flex flex-col gap-4">

        {{-- Cena --}}
        @if($ad->price)
            <div class="text-3xl font-bold text-indigo-600">
                {{ number_format($ad->price, 0, ',', '.') }} RSD
            </div>
        @endif

        {{-- Lokacija --}}
        <div class="text-sm text-slate-600">
            <strong>Lokacija:</strong>
            {{ $ad->location ?? 'Nepoznato' }}
        </div>

        {{-- Lokacija --}}
        <div class="text-sm text-slate-600">
            <strong>Lokacija:</strong>
            {{ $ad->location ?? 'Nepoznato' }}
        </div>

        {{-- Telefon --}}
        @if($ad->phone)
            <div class="text-sm text-slate-600">
                <strong>Telefon:</strong>
                {{ $ad->phone }}
            </div>
        @endif


        {{-- Stanje (condition) --}}
        @php
            $condition = is_string($ad->condition)
                ? $ad->condition
                : ($ad->condition->value ?? null);
        @endphp
        @if($condition)
            <div class="text-sm text-slate-600">
                <strong>Stanje:</strong>
                {{ $condition === 'new' ? 'Novo' : 'Polovno' }}
            </div>
        @endif

        {{-- Status --}}
        @php
            $status = is_string($ad->status) ? $ad->status : $ad->status->value;
        @endphp
        <div>
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                @if($status === 'active') bg-green-100 text-green-700
                @elseif($status === 'draft') bg-slate-100 text-slate-700
                @else bg-amber-100 text-amber-700 @endif">
                {{ ucfirst($status) }}
            </span>
        </div>

        {{-- Kategorija --}}
        <div class="text-sm text-slate-600">
            <strong>Kategorija:</strong>
            {{ $ad->category?->name ?? 'Nije podešeno' }}
        </div>

        {{-- Opis --}}
        <div>
            <h2 class="text-sm font-semibold">Opis</h2>
            <p class="text-sm text-slate-700 whitespace-pre-line">
                {{ $ad->description ?? 'Nema opisa.' }}
            </p>
        </div>

        {{-- Vlasnik --}}
        <div class="text-sm text-slate-600 border-t pt-3">
            <strong>Postavio:</strong>
            {{ $ad->user?->name ?? 'Nepoznat korisnik' }}
            <br>
            <strong>Datum:</strong>
            {{ $ad->created_at?->format('d.m.Y H:i') }}
            <br>
            <strong> Telefon:</strong>
            {{ $ad->user->phone ?? 'Nema telefona' }}

        </div>

    </div>
</div>
@endsection
