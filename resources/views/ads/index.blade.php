@extends('layouts.front')

@section('title', 'Početna - Mali oglasi')

{{-- SIDEBAR – kategorije --}}
@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Kategorije
        </h2>

        @if (!empty($cats) && count($cats))
            <ul class="space-y-1 text-sm">
                @foreach ($cats as $cat)
                    @php
                        $isActive = request()->routeIs('ads.by-category')
                            && request()->route('category')
                            && request()->route('category')->id === $cat->id;
                    @endphp

                    <li>
                        <a
                            href="{{ route('ads.by-category', $cat) }}"
                            class="
                                flex items-center justify-between rounded-md px-2 py-1.5
                                @if($isActive)
                                    bg-indigo-100 text-indigo-700 font-semibold
                                @else
                                    text-slate-700 hover:bg-slate-50 hover:text-indigo-600
                                @endif
                            "
                        >
                            <span>{{ $cat->name }}</span>

                            @if (isset($cat->ads_count))
                                <span class="text-xs text-slate-400">
                                    {{ $cat->ads_count }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-xs text-slate-500">
                Nema kategorija.
            </p>
        @endif
    </div>
@endsection

{{-- MAIN CONTENT --}}
@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                @isset($currentCategory)
                    Oglasi u kategoriji: {{ $currentCategory->name }}
                @else
                    Svi oglasi
                @endisset
            </h1>

            <p class="text-sm text-slate-500">
                @isset($currentCategory)
                    Pregled oglasa iz kategorije „{{ $currentCategory->name }}“.
                @else
                    Pregled najnovijih oglasa iz svih kategorija.
                @endisset
            </p>
        </div>

        @auth
            <a
                href="{{ route('ads.create') }}"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
            >
                + Postavi novi oglas
            </a>
        @endauth
    </div>

    {{-- SEARCH / FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('home') }}" class="grid gap-3 md:grid-cols-4 lg:grid-cols-6 items-end">
            {{-- Naziv / opis --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Naziv ili opis
                </label>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Telefon, bicikl, laptop..."
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Lokacija --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Lokacija
                </label>
                <input
                    type="text"
                    name="location"
                    value="{{ request('location') }}"
                    placeholder="Beograd, Niš..."
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Kategorija --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Kategorija
                </label>
                <select
                    name="category_id"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Sve kategorije</option>
                    @if (!empty($cats) && count($cats))
                        @foreach ($cats as $cat)
                            @php
                                $selected =
                                    (string) request('category_id') === (string) $cat->id
                                    || (isset($currentCategory) && $currentCategory->id === $cat->id);
                            @endphp

                            <option value="{{ $cat->id }}" @selected($selected)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Cena od --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cena od</label>
                <input
                    type="number"
                    name="price_min"
                    value="{{ request('price_min') }}"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Cena do --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cena do</label>
                <input
                    type="number"
                    name="price_max"
                    value="{{ request('price_max') }}"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Submit --}}
            <div class="md:col-span-2 lg:col-span-1">
                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                >
                    Pretraži
                </button>
            </div>
        </form>
    </div>

    {{-- LISTA OGLASA --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        @if ($ads->count())
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                @foreach ($ads as $ad)
                    <a href="{{ route('ads.show', $ad) }}" class="block group">
                        <article class="flex flex-col rounded-lg border border-slate-100 overflow-hidden hover:shadow-md transition-shadow bg-white">

                            {{-- Slika --}}
                            <div class="h-40 bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                                @if (!empty($ad->image_path))
                                    <img
                                        src="{{ asset('storage/' . $ad->image_path) }}"
                                        alt="{{ $ad->title }}"
                                        class="h-full w-full object-cover group-hover:scale-[1.02] transition-transform"
                                    >
                                @else
                                    Nema slike
                                @endif
                            </div>

                            <div class="p-3 flex flex-col gap-1">
                                <h2 class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-indigo-600">
                                    {{ $ad->title ?? 'Oglas #' . $ad->id }}
                                </h2>

                                @if (isset($ad->price))
                                    <p class="text-indigo-600 font-semibold text-sm">
                                        {{ number_format($ad->price, 0, ',', '.') }} RSD
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>
                                        {{ $ad->location ?? 'Nepoznata lokacija' }}
                                    </span>

                                    @php
                                   $condition = is_string($ad->condition) ? $ad->condition: ($ad->condition->value ?? null);
                                  @endphp

                                  @if ($condition)
                                      <span class="uppercase tracking-wide">
                                          {{ $condition === 'new' ? 'NOVO' : 'POLOVNO' }}
                                     </span>
                                  @endif
                                </div>

                                @if ($ad->phone)
                                <p class="text-xs text-slate-600 mt-1">
                                    Tel: {{ $ad->phone }}
                                </p>
                                @endif

                                @if ($ad->user?->name)
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Objavio: {{ $ad->user->name }}
                                </p>
                                 @endif

                                @if (isset($ad->description))
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
            <p class="text-sm text-slate-600">
                Trenutno nema oglasa.
            </p>
        @endif
    </div>
@endsection
