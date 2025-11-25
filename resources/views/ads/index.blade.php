@extends('layouts.front')

@section('title', 'Početna - Mali oglasi')

{{-- ========================= SIDEBAR – kategorije ========================= --}}
@section('sidebar')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
    <h2 class="text-sm font-semibold text-slate-800 mb-3">
        Kategorije
    </h2>

    @if (!empty($cats) && count($cats))
        <ul class="space-y-1 text-sm">
            @foreach ($cats as $cat)
                @include('ads.partials.category-node', ['category' => $cat])
            @endforeach
        </ul>
    @else
        <p class="text-xs text-slate-500">
            Nema kategorija.
        </p>
    @endif
</div>
@endsection



{{-- ========================= MAIN CONTENT ========================= --}}
@section('content')

    @php
        // Da li je bar jedan filter aktivan (osim paginacije)
        $hasFilters = request()->filled('q')
            || request()->filled('location')
            || request()->filled('category_id')
            || request()->filled('price_min')
            || request()->filled('price_max');
    @endphp

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @isset($currentCategory)
                    @if ($hasFilters)
                        Rezultati pretrage u kategoriji:
                        <span class="font-semibold">
                            {{ $currentCategory->full_path ?? $currentCategory->name }}
                        </span>
                    @else
                        Oglasi u kategoriji:
                        <span class="font-semibold">
                            {{ $currentCategory->full_path ?? $currentCategory->name }}
                        </span>
                    @endif
                @else
                    @if ($hasFilters)
                        Rezultati pretrage:
                    @else
                        Svi oglasi:
                    @endif
                @endisset
            </h1>
        </div>

        @auth
            <a href="{{ route('ads.create') }}"
               class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                + Postavi novi oglas
            </a>
        @endauth
    </div>


    {{-- ========================= SEARCH / FILTER ========================= --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">

        <form method="GET" action="{{ route('home') }}" class="grid gap-3 md:grid-cols-4 lg:grid-cols-6 items-end">

            {{-- Naziv / opis --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Naziv ili opis
                </label>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Telefon, bicikl, laptop..."
                       class="block w-full rounded-lg border-slate-300 text-sm shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Lokacija --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Lokacija
                </label>
                <input type="text" name="location" value="{{ request('location') }}"
                       placeholder="Beograd, Niš..."
                       class="block w-full rounded-lg border-slate-300 text-sm shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Kategorija --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Kategorija
                </label>

                <select name="category_id"
                        class="block w-full rounded-lg border-slate-300 text-sm shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Sve kategorije</option>

                    @if (!empty($cats) && count($cats))
                        @foreach ($cats as $cat)
                            <option value="{{ $cat->id }}"
                                @selected( request('category_id') == $cat->id )>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Cena od --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cena od</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}"
                       class="block w-full rounded-lg border-slate-300 text-sm shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Cena do --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cena do</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}"
                       class="block w-full rounded-lg border-slate-300 text-sm shadow-sm
                              focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Submit --}}
            <div class="md:col-span-2 lg:col-span-1">
                <button type="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                    Pretraži
                </button>
            </div>
        </form>

    </div>

   {{-- ========================= LISTA OGLASA ========================= --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">

        @if ($ads->count())
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

            @foreach ($ads as $ad)
                <a href="{{ route('ads.show', $ad) }}" class="block group">

                    <article class="flex flex-col rounded-lg border border-slate-100 overflow-hidden
                                    hover:shadow-md transition-shadow bg-white">

                        {{-- Slika --}}
                        <div class="h-40 bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                            @if ($ad->image_path)
                                <img src="{{ asset('storage/' . $ad->image_path) }}"
                                    alt="{{ $ad->title }}"
                                    class="h-full w-full object-cover group-hover:scale-[1.02] transition-transform">
                            @else
                                Nema slike
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-3 flex flex-col gap-2">

                            @php
                                $condition = is_string($ad->condition)
                                    ? $ad->condition
                                    : ($ad->condition->value ?? null);
                            @endphp

                            {{-- Naslov + status gore --}}
                            <div class="flex items-start justify-between gap-2">
                                <h2 class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-indigo-600 flex-1">
                                    {{ $ad->title }}
                                </h2>

                                @if ($condition)
                                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide shrink-0">
                                        {{ $condition === 'new' ? 'NOVO' : 'POLOVNO' }}
                                    </span>
                                @endif
                            </div>

                            {{-- Kategorija --}}
                            @if ($ad->category)
                                <p class="text-[11px] text-slate-500">
                                    {{ $ad->category->full_path }}
                                </p>
                            @endif

                            {{-- Cena --}}
                            @if ($ad->price)
                                <p class="text-indigo-600 font-semibold text-sm">
                                    {{ number_format($ad->price, 0, ',', '.') }} RSD
                                </p>
                            @endif

                            {{-- Lokacija --}}
                            <p class="text-xs text-slate-500">
                                {{ $ad->location ?? 'Nepoznata lokacija' }}
                            </p>

                            {{-- Opis --}}
                            @if ($ad->description)
                                <p class="text-xs text-slate-600 mt-1 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($ad->description, 90) }}
                                </p>
                            @endif

                        </div>

                    </article>

                </a>
            @endforeach

            </div>

            <div class="mt-4">
                {{ $ads->links() }}
            </div>

        @else
            <p class="text-sm text-slate-600">Trenutno nema oglasa.</p>
        @endif
    </div>
@endsection
