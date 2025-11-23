@extends('layouts.front')

@section('title', 'Postavi novi oglas - Mali oglasi')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Novi oglas
            </h1>
            <p class="text-sm text-slate-500">
                Popuni formu i postavi svoj oglas.
            </p>
        </div>

        <a
            href="{{ route('ads.my') }}"
            class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
        >
            ← Nazad na moje oglase
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">

            {{-- Validacioni errori --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold mb-1">Molimo proveri formu:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('ads.store') }}"
                  enctype="multipart/form-data">
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

                    {{-- Telefon --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Telefon
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="060 123 4567"
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
                            <option value="">Odaberi kategoriju</option>
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
                            <option value="new"  @selected($condition === 'new')>Novo</option>
                            <option value="used" @selected($condition === 'used')>Polovno</option>
                        </select>
                    </div>

                    {{-- Status oglasa --}}
                    <div class="mt-4">
                        <label for="status" class="block text-sm font-medium text-slate-700">Status *</label>

                        @php
                            $currentStatus = old('status', 'draft');
                        @endphp

                        <select
                            name="status"
                            id="status"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1"
                            required
                        >
                            <option value="draft" @selected($currentStatus === 'draft')>
                                Draft
                            </option>
                            <option value="active" @selected($currentStatus === 'active')>
                                Aktivno
                            </option>
                            <option value="archived" @selected($currentStatus === 'archived')>
                                Arhivirano
                            </option>
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
                        href="{{ route('ads.my') }}"
                        class="text-sm font-medium text-slate-600 hover:text-slate-800"
                    >
                        Otkaži
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
