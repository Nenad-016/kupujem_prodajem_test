@extends('layouts.front')

@section('title', 'Kategorije - Admin - Mali oglasi')

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
                   class="text-slate-700 font-semibold">
                    Kategorije
                </a>
            </li>
            @if (Route::has('admin.ads.index'))
                <li>
                    <a href="{{ route('admin.ads.index') }}"
                       class="text-slate-700 hover:text-indigo-600">
                        Oglasi
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="mt-4 bg-slate-50 border border-slate-200 rounded-xl p-3">
        <p class="text-xs text-slate-700">
            Kategorije mogu imati <strong>parent</strong> kategoriju.  
            Korišćene su za prikaz hijerarhije (sidebar, breadcrumbs, filteri).
        </p>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Kategorije
            </h1>
            <p class="text-sm text-slate-500">
                Pregled svih kategorija i podkategorija sistema.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                + Nova kategorija
            </a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        @if ($categories->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs text-slate-500 uppercase">
                            <th class="py-2 px-4">Naziv</th>
                            <th class="py-2 px-4">Parent</th>
                            <th class="py-2 px-4 text-center">Broj oglasa</th>
                            <th class="py-2 px-4 text-right">Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-b last:border-0 border-slate-100">
                                <td class="py-2 px-4 align-middle">
                                    
                                    <div class="flex flex-col">
                                        <a href="{{ route('admin.categories.show', $category) }}"
                                           class="font-medium text-slate-800 hover:text-indigo-600">
                                            {{ $category->name }}
                                        </a>
                                        @if ($category->slug)
                                            <span class="text-[11px] text-slate-400">
                                                /{{ $category->slug }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-2 px-4 align-middle text-slate-700">
                               @php
                                   $parent = $category->parent;
                                   $grandParent = $parent?->parent;

                                if (! $parent) {
                                    // root
                                    $label = 'Glavna kategorija';
                                } elseif ($grandParent) {
                                    // dva nivoa: deda / parent
                                    $label = $grandParent->name . ' / ' . $parent->name;
                                } else {
                                    // samo jedan nivo
                                    $label = $parent->name;
                                }
                                @endphp
                                   @if (! $parent)
                                       <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium bg-slate-100 text-slate-700">
                                           {{ $label }}
                                       </span>
                                   @else
                                       <div class="flex flex-col">
                                           @if ($grandParent)
                                               <span class="text-[11px] text-slate-400">
                                                   {{ $grandParent->name }}
                                               </span>
                                           @endif
                                           <span class="text-xs text-slate-700">
                                               {{ $parent->name }}
                                           </span>
                                       </div>
                                   @endif
                               </td>
                                <td class="py-2 px-4 align-middle text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="text-xs font-medium text-indigo-600 hover:text-indigo-700">
                                            Uredi
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}"
                                              method="POST"
                                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu kategoriju?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs font-medium text-rose-600 hover:text-rose-700">
                                                Obriši
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-slate-200">
                {{ $categories->links() }}
            </div>
        @else
            <div class="p-4 text-sm text-slate-500">
                Trenutno nema kategorija.
                <a href="{{ route('admin.categories.create') }}" class="text-indigo-600 hover:text-indigo-700">
                    Kreiraj prvu kategoriju.
                </a>
            </div>
        @endif
    </div>
@endsection
