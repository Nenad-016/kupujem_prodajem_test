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
                <a href="{{ route('admin.categories.index') }}" class="text-slate-700 hover:text-indigo-600">
                    Kategorije
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
        Pregled sistema i brzi pristup administraciji kategorija i korisnika.
    </p>

    <div class="grid gap-4 md:grid-cols-3">
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
@endsection
