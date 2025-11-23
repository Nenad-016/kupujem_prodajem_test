@extends('layouts.front')

@section('title', 'Izmena oglasa - ' . $ad->title)

@section('sidebar')
    <div class="bg-white rounded-xl shadow-sm border p-4">
        <h2 class="text-sm font-semibold mb-3 text-slate-800">Brzi linkovi</h2>

        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600">
                    ← Nazad na početnu
                </a>
            </li>
            <li>
                <a href="{{ route('ads.my') }}" class="text-slate-700 hover:text-indigo-600">
                    Moji oglasi
                </a>
            </li>
            <li>
                <a href="{{ route('ads.create') }}" class="text-slate-700 hover:text-indigo-600">
                    + Novi oglas
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Izmena oglasa</h1>
            <p class="text-sm text-slate-500">Ažuriraj podatke svog oglasa.</p>
        </div>

        <a href="{{ route('ads.my') }}"
           class="inline-flex items-center rounded-lg border px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
            ← Nazad
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border p-6">

            @if ($errors->any())
                <div class="mb-4 border border-rose-300 bg-rose-50 text-rose-700 px-4 py-3 rounded-lg text-sm">
                    <p class="font-semibold mb-1">Molimo proverite podatke:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('ads.update', $ad) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">

                    {{-- Naslov --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5">Naslov *</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $ad->title) }}"
                               required
                               class="block w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- Opis --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5">Opis *</label>
                        <textarea name="description"
                                  rows="4"
                                  class="block w-full border rounded-lg px-3 py-2 text-sm">{{ old('description', $ad->description) }}</textarea>
                    </div>

                    {{-- Cena --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1.5">Cena (RSD)</label>
                        <input type="number"
                               name="price"
                               value="{{ old('price', $ad->price) }}"
                               class="block w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- Lokacija --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1.5">Lokacija</label>
                        <input type="text"
                               name="location"
                               value="{{ old('location', $ad->location) }}"
                               class="block w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- Telefon --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Telefon
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $ad->phone) }}"
                            class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="060 123 4567"
                        >
                    </div>

                    {{-- Kategorija --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5">Kategorija *</label>
                        <select name="category_id"
                                required
                                class="block w-full border rounded-lg px-3 py-2 text-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected($category->id == old('category_id', $ad->category_id))>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stanje --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1.5">Stanje *</label>
                        <select name="condition"
                                required
                                class="block w-full border rounded-lg px-3 py-2 text-sm">
                            <option value="new" @selected($ad->condition === 'new')>Novo</option>
                            <option value="used" @selected($ad->condition === 'used')>Polovno</option>
                        </select>
                    </div>

                    {{-- Status oglasa --}}
                    <div class="mt-4">
                        <label for="status" class="block text-sm font-medium text-slate-700">Status *</label>

                        @php
                            $rawStatus = $ad->status ?? 'draft';

                            $defaultStatus = is_string($rawStatus) ? $rawStatus : ($rawStatus->value ?? 'draft');

                            $currentStatus = old('status', $defaultStatus);
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
                        <label class="block text-xs font-semibold mb-1.5">Slika (opciono)</label>

                        @if($ad->image_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $ad->image_path) }}"
                                     class="h-32 rounded-lg object-cover border">
                            </div>
                        @endif

                        <input type="file" name="image"
                               accept="image/*"
                               class="block w-full">
                    </div>

                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                            class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Sačuvaj izmene
                    </button>

                    <a href="{{ route('ads.my') }}" class="text-sm text-slate-600 hover:text-slate-900">
                        Otkaži
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
