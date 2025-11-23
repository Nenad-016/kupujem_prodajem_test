@extends('layouts.front')

@section('title', 'Novi oglas - Admin - Mali oglasi')

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
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Novi oglas
            </h1>
            <p class="text-sm text-slate-500">
                Kreiranje novog oglasa u sistemu.
            </p>
        </div>

        <a
            href="{{ route('admin.ads.index') }}"
            class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
        >
            ← Nazad na oglase
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold mb-1">Molimo proverite formu:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-4 md:gap-5 md:grid-cols-2">
                    {{-- Naslov --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Naslov oglasa *
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Prodajem biciklu..."
                            required
                        >
                    </div>

                    {{-- Opis --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Opis
                        </label>
                        <textarea
                            name="description"
                            rows="4"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-y"
                            placeholder="Detaljniji opis oglasa..."
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Cena --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Cena (RSD)
                        </label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            min="0"
                            step="1"
                        >
                    </div>

                    {{-- Lokacija --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Lokacija
                        </label>
                        <input
                            type="text"
                            name="location"
                            value="{{ old('location') }}"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Beograd, Niš..."
                        >
                    </div>

                    {{-- Kategorija --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kategorija *
                        </label>
                        <select
                            name="category_id"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">Odaberite kategoriju</option>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Vlasnik --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Vlasnik oglasa (korisnik) *
                        </label>
                        <select
                            name="user_id"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">Odaberite korisnika</option>
                            @foreach ($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('user_id') == $user->id)
                                >
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stanje (condition) --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Stanje *
                        </label>
                        @php
                            $condition = old('condition', 'new');
                        @endphp
                        <select
                            name="condition"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="new" @selected($condition === 'new')>Novo</option>
                            <option value="used" @selected($condition === 'used')>Polovno</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Status *
                        </label>
                        @php
                            $statusOptions = [
                                'draft'    => 'Draft',
                                'active'   => 'Aktivan',
                                'archived' => 'Arhiviran',
                            ];
                            $currentStatus = old('status', 'active');
                        @endphp
                        <select
                            name="status"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected($currentStatus === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Slika --}}
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
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                    >
                        Sačuvaj oglas
                    </button>

                    <a
                        href="{{ route('admin.ads.index') }}"
                        class="text-sm font-medium text-slate-600 hover:text-slate-800"
                    >
                        Otkaži
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
