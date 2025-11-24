@extends('layouts.front')

@section('title', 'Oglasi - Admin - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Admin navigacija
        </h2>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="text-slate-700 hover:text-indigo-600">
                    Kategorije
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="text-slate-700 hover:text-indigo-600">
                    Korisnici
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ads.index') }}" class="text-indigo-600 font-semibold">
                    Oglasi
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Oglasi
            </h1>
            <p class="text-sm text-slate-500">
                Pregled svih oglasa u sistemu.
            </p>
        </div>

        <a
            href="{{ route('admin.ads.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
        >
            + Kreiraj oglas
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Naslov</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Korisnik</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Kategorija</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Cena</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Kreiran</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($ads as $ad)
                    @php
                        // Normalizujemo status na string (active/draft/...),
                        // bez obzira da li je enum ili plain string.
                        $status = is_string($ad->status)
                            ? $ad->status
                            : ($ad->status->value ?? null);
                    @endphp

                    <tr @class([
                        // ako je soft-deleted, malo ga "izbleđujemo"
                        'bg-slate-50 opacity-60' => $ad->trashed(),
                    ])>
                        <td class="px-4 py-2 text-slate-500 align-middle">
                            #{{ $ad->id }}
                        </td>

                        <td class="px-4 py-2 align-middle">
                            <div class="font-medium text-slate-900 line-clamp-1">
                                {{ $ad->title }}
                            </div>
                        </td>

                        <td class="px-4 py-2 align-middle text-slate-700">
                            @if($ad->user)
                                <div class="flex items-center gap-2">
                                    <x-avatar :user="$ad->user" size="sm" />
                                    <span>{{ $ad->user->name }}</span>
                                </div>
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-4 py-2 align-middle text-slate-700">
                            {{ $ad->category?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-2 align-middle">
                            @if ($ad->trashed())
                                {{-- Ako je soft-deleted, jasno označimo --}}
                                <span class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-700">
                                    Obrisano
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                    @if($status === 'active')
                                        bg-emerald-100 text-emerald-700
                                    @elseif($status === 'draft')
                                        bg-slate-100 text-slate-700
                                    @else
                                        bg-amber-100 text-amber-700
                                    @endif
                                ">
                                    {{ $status ? ucfirst($status) : '—' }}
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2 align-middle text-slate-700">
                            @if($ad->price)
                                {{ number_format($ad->price, 0, ',', '.') }} RSD
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-4 py-2 align-middle text-slate-500">
                            {{ $ad->created_at?->format('d.m.Y H:i') }}
                        </td>

                        <td class="px-4 py-2 align-middle text-right space-x-2">
                            @if ($ad->trashed())
                                {{-- UNDO / RESTORE --}}
                                <form action="{{ route('admin.ads.restore', $ad->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs text-emerald-700 hover:text-emerald-900">
                                        Vrati
                                    </button>
                                </form>
                            @else
                                {{-- Uredi --}}
                                <a href="{{ route('ads.edit', $ad) }}"
                                   class="text-xs text-indigo-600 hover:text-indigo-800">
                                    Uredi
                                </a>

                                {{-- Obriši (soft delete) --}}
                                <form action="{{ route('admin.ads.destroy', $ad) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj oglas?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-rose-600 hover:text-rose-800">
                                        Obriši
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">
                            Trenutno nema oglasa u sistemu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-slate-100 px-4 py-3">
            {{ $ads->links() }}
        </div>
    </div>
@endsection
