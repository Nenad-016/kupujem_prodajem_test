@extends('layouts.front')

@section('title', $user->name . ' - Profil korisnika - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            O korisniku
        </h2>

        <p class="text-sm font-semibold text-slate-900">
            {{ $user->name }}
        </p>

        <p class="text-xs text-slate-500 mt-1">
            Član od: {{ optional($user->created_at)->format('d.m.Y.') }}
        </p>

        <p class="text-xs text-slate-500 mt-2">
            Ukupno oglasa: <strong>{{ $adsCount }}</strong>
        </p>
        <br>

        @php
            $adForInfo = $primaryAd ?? $ads->first();
        @endphp
        {{-- 📞 Telefon --}}
        @if($adForInfo && $adForInfo->phone)
            <div class="text-sm text-slate-600 mb-1">
                <strong>Telefon:</strong>
                {{ $adForInfo->phone }}
            </div>
        @endif

        {{-- 📍 Lokacija --}}
        @if($adForInfo && $adForInfo->location)
            <div class="text-sm text-slate-600 mb-1">
                <strong>Lokacija:</strong>
                {{ $adForInfo->location }}
            </div>
        @endif

        <div class="mt-3 space-y-1 text-xs">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">
                ← Nazad na početnu
            </a>

            @auth
                <a href="{{ route('ads.my') }}" class="block text-slate-600 hover:underline">
                    Moji oglasi
                </a>
            @endauth
        </div>
        
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Profil korisnika: {{ $user->name }}
            </h1>
            <p class="text-sm text-slate-500">
                Pregled oglasa koje je postavio ovaj korisnik.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        @if ($ads->count())
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($ads as $ad)
                    <article class="flex flex-col rounded-lg border border-slate-100 overflow-hidden hover:shadow-md transition-shadow bg-white">
                        {{-- Slika --}}
                        <div class="h-40 bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                            @if ($ad->image_path)
                                <img
                                    src="{{ asset('storage/' . $ad->image_path) }}"
                                    alt="{{ $ad->title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                Nema slike
                            @endif
                        </div>

                        <div class="p-3 flex flex-col gap-1">
                            <h2 class="text-sm font-semibold text-slate-900 line-clamp-2">
                                <a href="{{ route('ads.show', $ad) }}" class="hover:text-indigo-600">
                                    {{ $ad->title ?? 'Oglas #' . $ad->id }}
                                </a>
                            </h2>

                            @if ($ad->category)
                                <p class="text-[11px] text-slate-500">
                                    {{ $ad->category->full_path }}
                                </p>
                            @endif
                            @if ($ad->price !== null)
                                <p class="text-indigo-600 font-semibold text-sm">
                                    {{ number_format($ad->price, 0, ',', '.') }} RSD
                                </p>
                            @endif

                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $ad->location ?? 'Nepoznata lokacija' }}</span>

                                @if ($ad->condition)
                                    <span class="uppercase tracking-wide">
                                        {{ $ad->condition === 'new' ? 'NOVO' : 'POLOVNO' }}
                                    </span>
                                @endif
                            </div>

                            @if ($ad->phone)
                                <p class="text-[11px] text-slate-500 mt-1">
                                    Tel: {{ $ad->phone }}
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $ads->links() }}
            </div>
        @else
            <p class="text-sm text-slate-600">
                Ovaj korisnik trenutno nema oglasa.
            </p>
        @endif
    </div>
@endsection
