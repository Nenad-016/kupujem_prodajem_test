{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.front')

@section('title', 'Admin dashboard - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Admin navigacija
        </h2>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center justify-between text-slate-700 hover:text-indigo-600">
                    <span>Dashboard</span>
                    <span class="text-[10px] uppercase tracking-wide text-slate-400">HOME</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center justify-between text-slate-700 hover:text-indigo-600">
                    <span>Kategorije</span>
                    <span class="text-[10px] uppercase tracking-wide text-slate-400">STRUKTURA</span>
                </a>
            </li>

            @if (Route::has('admin.ads.index'))
                <li>
                    <a href="{{ route('admin.ads.index') }}"
                       class="flex items-center justify-between text-slate-700 hover:text-indigo-600">
                        <span>Oglasi</span>
                        <span class="text-[10px] uppercase tracking-wide text-slate-400">LISTA</span>
                    </a>
                </li>
            @endif

            @if (Route::has('admin.users.index'))
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center justify-between text-slate-700 hover:text-indigo-600">
                        <span>Korisnici</span>
                        <span class="text-[10px] uppercase tracking-wide text-slate-400">ADMIN</span>
                    </a>
                </li>
            @endif

            <li class="pt-2 mt-2 border-t border-slate-200">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na početnu
                </a>
            </li>
        </ul>
    </div>

    {{-- Mali hint za hijerarhiju --}}
    <div class="mt-4 bg-indigo-50 border border-indigo-100 rounded-xl p-3">
        <p class="text-xs text-indigo-900">
            Ovde uređuješ <strong>glavne kategorije</strong> i njihove
            <strong>podkategorije</strong>.  
            Hijerarhija utiče na sidebar, breadcrumbs i search na javnom delu sajta.
        </p>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Admin dashboard
            </h1>
            <p class="text-sm text-slate-500">
                Pregled sistema i brzi pristup administraciji oglasa, kategorija i korisnika.
            </p>
        </div>

        @auth
            <div class="hidden sm:flex flex-col items-end">
                <span class="text-xs text-slate-400 uppercase tracking-wide mb-1">Prijavljen kao</span>
                <span class="text-sm font-semibold text-slate-800">
                    {{ auth()->user()->name ?? auth()->user()->email }}
                </span>
            </div>
        @endauth
    </div>

    {{-- Stat kartice --}}
    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Ukupno oglasa</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['ads_count'] ?? '—' }}
            </p>
            @if (!empty($stats['ads_today']))
                <p class="text-xs text-emerald-600 mt-1">
                    +{{ $stats['ads_today'] }} danas
                </p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Ukupno korisnika</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['users_count'] ?? '—' }}
            </p>
            @if (!empty($stats['users_today']))
                <p class="text-xs text-emerald-600 mt-1">
                    +{{ $stats['users_today'] }} novih danas
                </p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Kategorije</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['categories_count'] ?? '—' }}
            </p>
            @if (!empty($stats['root_categories_count']))
                <p class="text-xs text-slate-500 mt-1">
                    {{ $stats['root_categories_count'] }} glavnih /
                    {{ ($stats['categories_count'] ?? 0) - $stats['root_categories_count'] }} podkategorija
                </p>
            @endif
        </div>
    </div>

    {{-- Donji deo: poslednji oglasi + tree kategorija --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Poslednji oglasi --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">
                    Poslednji oglasi
                </h2>
                @if (Route::has('admin.ads.index'))
                    <a href="{{ route('admin.ads.index') }}"
                       class="text-xs font-medium text-indigo-600 hover:text-indigo-700">
                        Vidi sve →
                    </a>
                @endif
            </div>

            @if(isset($latestAds) && $latestAds->count())
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-left text-xs text-slate-500 uppercase">
                                <th class="py-2 pr-3 pl-4 sm:pl-0">Naslov</th>
                                <th class="py-2 px-3">Kategorija</th>
                                <th class="py-2 px-3">Korisnik</th>
                                <th class="py-2 px-3">Status</th>
                                <th class="py-2 pl-3 pr-4 sm:pr-0 text-right">Datum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestAds as $ad)
                                <tr class="border-b last:border-0 border-slate-100">
                                    <td class="py-2 pr-3 pl-4 sm:pl-0">
                                        <a href="{{ route('admin.ads.edit', $ad) }}"
                                           class="font-medium text-slate-800 hover:text-indigo-600">
                                            {{ \Illuminate\Support\Str::limit($ad->title, 40) }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-3 text-slate-600">
                                        {{ $ad->category?->name ?? '—' }}
                                    </td>
                                    <td class="py-2 px-3 text-slate-600">
                                        {{ $ad->user?->name ?? '—' }}
                                    </td>
                                    <td class="py-2 px-3">
                                        @php
                                            $status = $ad->status ?? 'draft';
                                            $statusColor = match($status) {
                                                'published' => 'bg-emerald-100 text-emerald-800',
                                                'pending'   => 'bg-amber-100 text-amber-800',
                                                default     => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $statusColor }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 pl-3 pr-4 sm:pr-0 text-right text-xs text-slate-500">
                                        {{ $ad->created_at?->format('d.m.Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-xs text-slate-500">
                    Još uvek nema oglasa.
                </p>
            @endif
        </div>        
    </div>
@endsection
