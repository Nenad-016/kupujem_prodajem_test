@extends('layouts.front')

@section('title', 'Moji oglasi - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Brzi linkovi
        </h2>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na početnu
                </a>
            </li>
            <li>
                <a href="{{ route('ads.create') }}" class="text-slate-700 hover:text-indigo-600">
                    + Postavi novi oglas
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="text-slate-700 hover:text-indigo-600">
                    Podešavanja profila
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Moji oglasi
            </h1>
            <p class="text-sm text-slate-500">
                Pregled i uređivanje svih oglasa koje je postavio korisnik
                {{ auth()->user()->name }}.
            </p>
        </div>

        <a
            href="{{ route('ads.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
        >
            + Novi oglas
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        @if($ads->count())
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Naslov</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Kategorija</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Cena</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Kreiran</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Akcije</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($ads as $ad)
                        @php
                            $status = is_string($ad->status) ? $ad->status : $ad->status->value;
                        @endphp
                        <tr>
                            {{-- Naslov --}}
                            <td class="px-4 py-2 align-middle">
                                <div class="font-medium text-slate-900 line-clamp-1">
                                    <a href="{{ route('ads.show', $ad) }}" class="hover:text-indigo-600">
                                        {{ $ad->title ?? 'Oglas #' . $ad->id }}
                                    </a>
                                </div>
                                <div class="text-xs text-slate-500 md:hidden mt-0.5">
                                    {{ $ad->category?->name ?? 'Bez kategorije' }}
                                </div>
                            </td>

                            {{-- Kategorija --}}
                            <td class="px-4 py-2 align-middle text-slate-700 hidden md:table-cell">
                                {{ $ad->category?->name ?? 'Bez kategorije' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-2 align-middle">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                    @if($status === 'active')
                                        bg-emerald-100 text-emerald-700
                                    @elseif($status === 'draft')
                                        bg-slate-100 text-slate-700
                                    @else
                                        bg-amber-100 text-amber-700
                                    @endif
                                ">
                                    {{ $status === 'active' ? 'Aktivan' : ($status === 'draft' ? 'Draft' : 'Arhiviran') }}
                                </span>
                            </td>

                            {{-- Cena --}}
                            <td class="px-4 py-2 align-middle text-slate-700">
                                @if($ad->price)
                                    {{ number_format($ad->price, 0, ',', '.') }} RSD
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Kreiran --}}
                            <td class="px-4 py-2 align-middle text-slate-500 hidden md:table-cell">
                                {{ $ad->created_at?->format('d.m.Y H:i') }}
                            </td>

                            {{-- Akcije --}}
                            <td class="px-4 py-2 align-middle text-right space-x-2">
                                <a
                                    href="{{ route('ads.show', $ad) }}"
                                    class="text-xs text-slate-600 hover:text-slate-800"
                                >
                                    Pogledaj
                                </a>

                                <a
                                    href="{{ route('ads.edit', $ad) }}"
                                    class="text-xs text-indigo-600 hover:text-indigo-800"
                                >
                                    Uredi
                                </a>

                                <form
                                    action="{{ route('ads.destroy', $ad) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj oglas?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-xs text-rose-600 hover:text-rose-800"
                                    >
                                        Obriši
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($ads instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="border-top border-slate-100 px-4 py-3">
                    {{ $ads->links() }}
                </div>
            @endif
        @else
            <div class="px-4 py-6 text-sm text-slate-600">
                Trenutno nemaš postavljenih oglasa.
                <a href="{{ route('ads.create') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    Postavi svoj prvi oglas.
                </a>
            </div>
        @endif
    </div>
@endsection
