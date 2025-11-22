{{-- resources/views/ads/my.blade.php --}}
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
                Pregled i uređivanje svih oglasa koje je postavio korisnik {{ auth()->user()->name }}.
            </p>
        </div>

        <a
            href="{{ route('ads.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
        >
            + Novi oglas
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        @if($ads->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500">
                            <th class="py-2 pr-3">Naslov</th>
                            <th class="py-2 px-3">Cena</th>
                            <th class="py-2 px-3">Lokacija</th>
                            <th class="py-2 px-3">Stanje</th>
                            <th class="py-2 px-3 text-right">Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ads as $ad)
                            <tr class="border-b border-slate-100">
                                <td class="py-2 pr-3">
                                    <a href="{{ route('ads.show', $ad) }}" class="text-slate-800 hover:text-indigo-600 font-medium">
                                        {{ $ad->title }}
                                    </a>
                                </td>
                                <td class="py-2 px-3">
                                    {{ number_format($ad->price, 0, ',', '.') }} RSD
                                </td>
                                <td class="py-2 px-3">
                                    {{ $ad->location }}
                                </td>
                                <td class="py-2 px-3 text-xs uppercase text-slate-500">
                                    {{ $ad->condition === 'new' ? 'Novo' : 'Polovno' }}
                                </td>
                                <td class="py-2 px-3 text-right space-x-2">
                                    <a
                                        href="{{ route('ads.edit', $ad) }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-700"
                                    >
                                        Izmeni
                                    </a>

                                    <form action="{{ route('ads.destroy', $ad) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-xs text-red-600 hover:text-red-700"
                                            onclick="return confirm('Da li si siguran da želiš da obrišeš ovaj oglas?')"
                                        >
                                            Obriši
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $ads->links() }}
            </div>
        @else
            <p class="text-sm text-slate-600">
                Trenutno nemaš postavljenih oglasa.  
                <a href="{{ route('ads.create') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Postavi svoj prvi oglas.
                </a>
            </p>
        @endif
    </div>
@endsection
