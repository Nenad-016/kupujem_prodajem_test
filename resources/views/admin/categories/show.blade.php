@extends('layouts.front')

@section('title', 'Kategorija: ' . $category->name . ' - Admin - Mali oglasi')

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <h2 class="text-sm font-semibold text-slate-800 mb-3">
            Admin navigacija
        </h2>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-slate-700 hover:text-indigo-600">
                    ← Sve kategorije
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.edit', $category) }}"
                   class="text-slate-700 hover:text-indigo-600">
                    Uredi ovu kategoriju
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    @php
        $parent = $category->parent;
        $grandParent = $parent?->parent;
    @endphp

    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $category->name }}
            </h1>
            <p class="text-sm text-slate-500">
                Pregled pojedinačne kategorije, hijerarhije i povezanih oglasa.
            </p>

            <div class="mt-2 text-xs text-slate-500">
                @if ($grandParent)
                    {{ $grandParent->name }} /
                @endif

                @if ($parent)
                    {{ $parent->name }} /
                @endif

                <span class="font-semibold text-slate-700">
                    {{ $category->name }}
                </span>
            </div>

            <div class="mt-1 text-[11px] text-slate-400">
                /{{ $category->slug }}
            </div>
        </div>

        <a href="{{ route('admin.categories.edit', $category) }}"
           class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700">
            Uredi kategoriju
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-3 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Broj oglasa</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $category->ads()->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Broj direktnih podkategorija</h2>
            <p class="text-2xl font-bold text-slate-900">
                {{ $category->children->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <h2 class="text-xs font-semibold text-slate-500 uppercase mb-1">Tip</h2>
            <p class="text-sm font-medium text-slate-900">
                @if (!$parent)
                    Glavna kategorija
                @elseif ($grandParent)
                    Podkategorija (nivo 2)
                @else
                    Podkategorija
                @endif
            </p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">
                    Direktne podkategorije
                </h2>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-xs text-indigo-600 hover:text-indigo-700">
                    Sve kategorije
                </a>
            </div>

            @if ($category->children->count())
                <ul class="space-y-1 text-sm">
                    @foreach ($category->children as $child)
                        <li class="flex items-center justify-between py-1 border-b last:border-0 border-slate-100">
                            <div>
                                <a href="{{ route('admin.categories.show', $child) }}"
                                   class="text-slate-800 hover:text-indigo-600">
                                    {{ $child->name }}
                                </a>
                                @if ($child->children->count())
                                    <div class="text-[11px] text-slate-400">
                                        {{ $child->children->count() }} podkategorija
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('admin.categories.edit', $child) }}"
                               class="text-xs text-indigo-600 hover:text-indigo-700">
                                Uredi
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-slate-500">
                    Ova kategorija trenutno nema podkategorija.
                </p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">
                    Poslednji oglasi u ovoj kategoriji
                </h2>
                <a href="{{ route('ads.by-category', $category) }}"
                   class="text-xs text-indigo-600 hover:text-indigo-700">
                    Otvori javni prikaz
                </a>
            </div>

            @if ($category->ads->count())
                <ul class="space-y-2 text-sm">
                    @foreach ($category->ads as $ad)
                        <li class="border-b last:border-0 border-slate-100 pb-2">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-slate-800">
                                    {{ $ad->title }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    {{ $ad->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            <div class="text-[12px] text-slate-500">
                                {{ Str::limit($ad->description, 80) }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-slate-500">
                    Trenutno nema oglasa u ovoj kategoriji.
                </p>
            @endif
        </div>
    </div>
@endsection
