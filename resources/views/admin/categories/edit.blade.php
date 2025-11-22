@extends('layouts.front')

@section('title', 'Uredi kategoriju - Admin - Mali oglasi')

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
                    Kategorije
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Uredi kategoriju
            </h1>
            <p class="text-sm text-slate-500">
                Ažuriraj naziv, slug ili parent kategoriju.
            </p>
        </div>

        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu kategoriju?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100">
                Obriši kategoriju
            </button>
        </form>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.categories._form', [
            'category' => $category,
            'parents' => $parents,
        ])
    </form>
@endsection
