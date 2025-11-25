@extends('layouts.front')

@section('title', 'Admin dashboard - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Admin navigacija
        </h2>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-semibold">
                    Dashboard
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
                <a href="{{ route('admin.ads.index') }}" class="text-slate-700 hover:text-indigo-600">
                    Oglasi
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ad_reports.index') }}" class="text-slate-700 hover:text-indigo-600">
                    Prijave oglasa
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na početnu
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 mb-2">
        Admin dashboard
    </h1>
    <p class="text-sm text-slate-500 mb-6">
        Pregled sistema i brzi pristup administraciji oglasa, kategorija i korisnika.
    </p>

    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Ukupno oglasa</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['ads_count'] ?? '—' }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Ukupno korisnika</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['users_count'] ?? '—' }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Kategorije</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $stats['categories_count'] ?? '—' }}
            </p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h3 class="text-sm font-semibold text-slate-800 mb-2">
                Upravljanje oglasima
            </h3>
            <p class="text-xs text-slate-500 mb-3">
                Pregled, izmena i brisanje svih oglasa u sistemu.
            </p>
            <a href="{{ route('admin.ads.index') }}"
               class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700">
                Idi na oglase
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h3 class="text-sm font-semibold text-slate-800 mb-2">
                Upravljanje korisnicima
            </h3>
            <p class="text-xs text-slate-500 mb-3">
                Pregled naloga, uloga i administracija korisnika.
            </p>
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center rounded-lg bg-slate-800 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-slate-900">
                Idi na korisnike
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h3 class="text-sm font-semibold text-slate-800 mb-2">
                Upravljanje kategorijama
            </h3>
            <p class="text-xs text-slate-500 mb-3">
                Kreiranje, izmena i organizacija hijerarhije kategorija.
            </p>
            <a href="{{ route('admin.categories.index') }}
               "class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-800 shadow-sm hover:bg-slate-200">
                Idi na kategorije
            </a>
        </div>
    </div>
@endsection
