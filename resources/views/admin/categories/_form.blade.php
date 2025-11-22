@php
    /** @var \App\Models\Category|null $category */
    $isEdit = isset($category);
@endphp

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-100 px-4 py-2 text-sm text-rose-800">
            <p class="font-semibold mb-1">Došlo je do grešaka pri snimanju:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Name --}}
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-slate-700">
            Naziv kategorije
        </label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $category->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >
        <p class="mt-1 text-xs text-slate-500">
            Ovo je naziv koji će se prikazivati korisnicima.
        </p>
    </div>

    {{-- Slug --}}
    <div class="mb-4">
        <label for="slug" class="block text-sm font-medium text-slate-700">
            Slug (URL deo)
        </label>
        <input
            type="text"
            name="slug"
            id="slug"
            value="{{ old('slug', $category->slug ?? '') }}"
            class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="prazno = automatski iz naziva"
        >
        <p class="mt-1 text-xs text-slate-500">
            Ako ostaviš prazno, biće generisan automatski iz naziva.
        </p>
    </div>

    <div class="mb-4">
        <label for="parent_id" class="block text-sm font-medium text-slate-700">
            Glavna kategorija
        </label>
        <select
            name="parent_id"
            id="parent_id"
            class="mt-1 block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
            <option value="">— Nema glavnih kategorija —</option>

            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}"
                    @selected(old('parent_id', $category->parent_id ?? null) == $parent->id)>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-slate-500">
            Ako izabereš glavnu kategoriju, ova kategorija će biti podkategorija.
        </p>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}"
           class="text-sm text-slate-500 hover:text-slate-700">
            ← Nazad na listu kategorija
        </a>

        <button type="submit"
                class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
            {{ $isEdit ? 'Sačuvaj izmene' : 'Kreiraj kategoriju' }}
        </button>
    </div>
</div>
