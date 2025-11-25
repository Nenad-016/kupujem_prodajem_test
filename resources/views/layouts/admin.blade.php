@extends('layouts.front')

@section('title', 'Prijave oglasa - Admin panel')

{{-- Leva kolona – ista kao na admin dashboardu --}}
@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border p-4">
        <h2 class="text-sm font-semibold mb-3 text-slate-800">Admin navigacija</h2>

        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    Kategorije
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    Korisnici
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ads.index') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    Oglasi
                </a>
            </li>
            <li>
                <span class="text-indigo-600 font-semibold">
                    Prijave oglasa
                </span>
            </li>
            <li class="pt-2">
                <a href="{{ route('home') }}"
                   class="text-slate-500 hover:text-indigo-600">
                    ← Nazad na početnu
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Prijave oglasa</h1>
            <p class="text-sm text-slate-500">
                Pregled prijava koje su korisnici poslali za oglase.
            </p>
        </div>

        {{-- Filter po statusu --}}
        <form method="GET" action="{{ route('admin.ad_reports.index') }}" class="flex items-center gap-2">
            <select name="status"
                    class="text-sm rounded-lg border-slate-300 shadow-sm px-3 py-1.5 bg-white">
                <option value="">Svi statusi</option>
                <option value="pending" @selected(request('status') === 'pending')>Na čekanju</option>
                <option value="reviewed" @selected(request('status') === 'reviewed')>Pregledano</option>
                <option value="dismissed" @selected(request('status') === 'dismissed')>Odbijeno</option>
            </select>

            <button type="submit"
                    class="inline-flex items-center gap-1 rounded-lg bg-slate-800 text-white text-sm px-3 py-1.5 hover:bg-slate-900">
                <span>Filtriraj</span>
            </button>
        </form>
    </div>
    {{-- Tabela prijava --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">Oglas</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">Prijavio</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">Razlog</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">Poruka</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500">Status</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-b last:border-b-0 hover:bg-slate-50">
                        {{-- ID --}}
                        <td class="px-4 py-3 align-top text-xs text-slate-500">
                            #{{ $report->id }}
                        </td>

                        {{-- Oglas --}}
                        <td class="px-4 py-3 align-top">
                            @if($report->ad)
                                <a href="{{ route('ads.show', $report->ad) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    {{ $report->ad->title }}
                                </a>
                                <div class="text-xs text-slate-400">
                                    ID oglasa: {{ $report->ad->id }}
                                </div>
                            @else
                                <span class="text-xs text-slate-400">Oglas obrisan</span>
                            @endif
                        </td>

                        {{-- Prijavio --}}
                        <td class="px-4 py-3 align-top">
                            @if($report->user)
                                <div class="text-sm text-slate-800">
                                    {{ $report->user->name }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $report->user->email }}
                                </div>
                            @else
                                <span class="text-xs text-slate-400">Nepoznat korisnik</span>
                            @endif
                        </td>

                        {{-- Razlog --}}
                        <td class="px-4 py-3 align-top">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-700">
                                {{ $report->reason }}
                            </span>
                        </td>

                        {{-- Poruka --}}
                        <td class="px-4 py-3 align-top">
                            @if($report->message)
                                <p class="text-xs text-slate-700 max-w-xs">
                                    {{ $report->message }}
                                </p>
                            @else
                                <span class="text-xs text-slate-400">Nema dodatne poruke</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3 align-top">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'reviewed' => 'bg-emerald-100 text-emerald-800',
                                    'dismissed' => 'bg-slate-100 text-slate-700',
                                ];
                            @endphp

                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusClasses[$report->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $report->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                        </td>

                        {{-- Akcije --}}
                        <td class="px-4 py-3 align-top text-right">
                            <form method="POST"
                                  action="{{ route('admin.ad_reports.updateStatus', $report) }}"
                                  class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        class="text-xs rounded-md border-slate-300 px-2 py-1 bg-white">
                                    <option value="pending" @selected($report->status === 'pending')>Pending</option>
                                    <option value="reviewed" @selected($report->status === 'reviewed')>Reviewed</option>
                                    <option value="dismissed" @selected($report->status === 'dismissed')>Dismissed</option>
                                </select>

                                <button type="submit"
                                        class="text-xs px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                    Sačuvaj
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">
                            Trenutno nema nijedne prijave oglasa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reports->withQueryString()->links() }}
    </div>
@endsection
