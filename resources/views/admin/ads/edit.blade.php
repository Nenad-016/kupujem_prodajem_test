@extends('layouts.front')

@section('title', 'Izmena oglasa - Admin - Mali oglasi')

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
                Izmena oglasa #{{ $ad->id }}
            </h1>
            <p class="text-sm text-slate-500">
                Ažuriranje podataka oglasa u sistemu.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @isset($ad->id)
                <a href="{{ route('ads.show', $ad) }}"
                   class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                   target="_blank">
                    Pogledaj javno
                </a>
            @endisset

            <a href="{{ route('admin.ads.index') }}"
               class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                ← Nazad na oglase
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.ads.update', $ad) }}">
            @csrf
            @method('PUT')

            {{-- Naslov --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Naslov oglasa *
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $ad->title) }}"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Opis --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Opis
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >{{ old('description', $ad->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cena & Lokacija --}}
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                        Cena (RSD)
                    </label>
                    <input
                        type="number"
                        name="price"
                        value="{{ old('price', $ad->price) }}"
                        step="1"
                        min="0"
                        class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                        Lokacija
                    </label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location', $ad->location) }}"
                        class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('location')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kategorija & Korisnik --}}
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                        Kategorija *
                    </label>
                    <select
                        name="category_id"
                        class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                        <option value="">— Odaberi kategoriju —</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $ad->category_id) == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                        Vlasnik oglasa (korisnik) *
                    </label>
                    <select
                        name="user_id"
                        class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                        <option value="">— Odaberi korisnika —</option>
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                @selected(old('user_id', $ad->user_id) == $user->id)
                            >
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Upload slike --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Slika oglasa
                </label>

                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                @error('image')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            @php
                $currentStatus = old(
                    'status',
                    is_string($ad->status)
                        ? $ad->status
                        : ($ad->status->value ?? 'active')
                );
            @endphp

            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Status *
                </label>
                <select
                    name="status"
                    class="block w-full max-w-xs rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                    <option value="draft"    @selected($currentStatus === 'draft')>Draft</option>
                    <option value="active"   @selected($currentStatus === 'active')>Aktivan</option>
                    <option value="archived" @selected($currentStatus === 'archived')>Arhiviran</option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dugmad --}}
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                    >
                        Sačuvaj izmene
                    </button>

                    <a href="{{ route('admin.ads.index') }}"
                       class="text-sm text-slate-600 hover:text-slate-800">
                        Otkaži
                    </a>
                </div>

                <form
                    action="{{ route('admin.ads.destroy', $ad) }}"
                    method="POST"
                    onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj oglas?');"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="text-sm text-rose-600 hover:text-rose-800"
                    >
                        Obriši oglas
                    </button>
                </form>
            </div>
        </form>
    </div>
@endsection
