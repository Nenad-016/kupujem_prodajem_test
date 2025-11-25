@extends('layouts.front')

@section('title', $ad->title . ' - Mali oglasi')

@section('content')

@php
    $viewer = auth()->user();

    $canReport = !$viewer
        || (
            !$viewer->isAdmin()
            && $viewer->id !== $ad->user_id
        );
@endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">{{ $ad->title }}</h1>

        <a href="{{ url()->previous() }}"
           class="text-sm px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50">
            ← Nazad
        </a>
    </div>

    {{-- Glavni wrapper: oglas + prijava oglasa, ista širina --}}
    <div class="space-y-6">

        {{-- Kartica oglasa --}}
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

                {{-- Kategorija --}}
                <div class="text-sm text-slate-600">
                    <strong>Kategorija:</strong>
                    {{ $ad->category?->full_path ?? 'Nije podešeno' }}
                </div>

                {{-- Opis --}}
                <div>
                    <h2 class="text-sm font-semibold">Opis</h2>
                    <p class="text-sm text-slate-700">
                        {{ $ad->description ?? 'Nema opisa.' }}
                    </p>
                </div>

                {{-- Vlasnik --}}
                <div class="text-sm text-slate-600 border-t pt-3">
                    <strong>Postavio:</strong>
                    @if($ad->user)
                        <a
                            href="{{ route('users.profile', $ad->user) }}"
                            class="text-indigo-600 hover:underline"
                        >
                            {{ $ad->user->name }}
                        </a>
                    @else
                        Nepoznat korisnik
                    @endif
                    <br>
                    <strong>Datum:</strong>
                    {{ $ad->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>

     @if($canReport)
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4 text-slate-800">Prijavi oglas</h3>

        @auth
            <form method="POST" action="{{ route('ads.report', $ad) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Razlog prijave *
                    </label>

                    <select name="reason"
                            required
                            class="block w-full rounded-lg border-slate-300 shadow-sm px-3 py-2 text-sm">
                        <option value="">-- Odaberite razlog --</option>
                        <option value="spam" @selected(old('reason') === 'spam')>Spam / lažan oglas</option>
                        <option value="inappropriate" @selected(old('reason') === 'inappropriate')>Neprimeren sadržaj</option>
                        <option value="wrong_category" @selected(old('reason') === 'wrong_category')>Pogrešna kategorija</option>
                        <option value="fraud" @selected(old('reason') === 'fraud')>Prevara / sumnjiv oglas</option>
                        <option value="other" @selected(old('reason') === 'other')>Drugo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Dodatne informacije (opciono)
                    </label>
                    <textarea name="message"
                              rows="3"
                              class="block w-full rounded-lg border-slate-300 shadow-sm px-3 py-2 text-sm"
                              placeholder="Opišite ukratko u čemu je problem...">{{ old('message') }}</textarea>
                </div>

                <button type="submit"
                        class="px-4 py-2 bg-rose-600 text-white rounded-lg text-sm font-semibold hover:bg-rose-700">
                    Prijavi oglas
                </button>
            </form>
        @else
            <p class="text-xs text-slate-500">
                Da biste prijavili oglas, potrebno je da se
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">ulogujete</a>.
            </p>
        @endauth
    </div>
    @endif


    {{-- Još oglasa ovog korisnika --}}
    @if(isset($moreFromUser) && $moreFromUser->count())
        <div class="mt-10">
            <h2 class="text-lg font-bold text-slate-900 mb-4">
                Još oglasa ovog korisnika
            </h2>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($moreFromUser as $item)
                    <article class="flex flex-col rounded-lg border border-slate-200 overflow-hidden hover:shadow-md transition-shadow bg-white">

                        {{-- Slika --}}
                        <div class="h-32 bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                            @if ($item->image_path)
                                <img
                                    src="{{ asset('storage/' . $item->image_path) }}"
                                    alt="{{ $item->title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                Nema slike
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-3 flex flex-col gap-1">
                            <h3 class="text-sm font-semibold text-slate-900 line-clamp-2">
                                <a href="{{ route('ads.show', $item) }}" class="hover:text-indigo-600">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            @if ($item->price)
                                <p class="text-indigo-600 font-semibold text-sm">
                                    {{ number_format($item->price, 0, ',', '.') }} RSD
                                </p>
                            @endif

                            <p class="text-xs text-slate-500">
                                {{ $item->location ?? 'Nepoznato' }}
                            </p>
                        </div>

                    </article>
                @endforeach
            </div>
        </div>
    @endif
@endsection
