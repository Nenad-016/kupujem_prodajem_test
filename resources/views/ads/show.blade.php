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

    <div class="w-full max-w-[1450px] mx-auto px-0">

        {{-- Glavni layout: sidebar + sadržaj --}}
        <div class="grid grid-cols-1 lg:grid-cols-[260px,1fr] gap-6">

            {{-- Sidebar (tu već koristiš category-node preko sidebar-ads partiala) --}}
            <aside class="hidden lg:block">
                @include('ads.partials.sidebar-ads')
            </aside>

            {{-- Glavni sadržaj (naslov + oglas + prijava) --}}
            <div class="space-y-6">

                {{-- Naslov + Nazad – sada iznad SAMOG oglasa, u desnoj koloni --}}
                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-bold">{{ $ad->title }}</h1>

                    <a href="{{ url()->previous() }}"
                       class="text-sm px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50">
                        ← Nazad
                    </a>
                </div>

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

                        {{-- Stanje --}}
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

                {{-- Prijava oglasa --}}
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
                                        <option value="spam">Spam / lažan oglas</option>
                                        <option value="inappropriate">Neprimeren sadržaj</option>
                                        <option value="wrong_category">Pogrešna kategorija</option>
                                        <option value="fraud">Prevara / sumnjiv oglas</option>
                                        <option value="other">Drugo</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">
                                        Dodatne informacije (opciono)
                                    </label>
                                    <textarea name="message"
                                              rows="3"
                                              class="block w-full rounded-lg border-slate-300 shadow-sm px-3 py-2 text-sm"
                                              placeholder="Opišite ukratko u čemu je problem..."></textarea>
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

            </div>
        </div>

    </div>
@endsection
