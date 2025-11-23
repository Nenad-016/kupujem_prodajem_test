{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.front')

@section('title', 'Korisnici - Admin - Mali oglasi')

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
                <a href="{{ route('admin.users.index') }}" class="text-indigo-600 font-semibold">
                    Korisnici
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Korisnici
            </h1>
            <p class="text-sm text-slate-500">
                Pregled svih registrovanih korisnika sistema.
            </p>
        </div>

        <a
            href="{{ route('admin.users.create') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
        >
            + Novi korisnik
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Ime</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Uloga</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Oglasa</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Kreiran</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-2 align-middle text-slate-500">
                            #{{ $user->id }}
                        </td>
                        <td class="px-4 py-2 align-middle">
                            <div class="font-medium text-slate-900">
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="px-4 py-2 align-middle text-slate-700">
                            {{ $user->email }}
                        </td>
                        <td class="px-4 py-2 align-middle">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 align-middle text-slate-700">
                            {{ $user->ads_count ?? '—' }}
                        </td>
                        <td class="px-4 py-2 align-middle text-slate-500">
                            {{ $user->created_at?->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-4 py-2 align-middle text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-xs text-indigo-600 hover:text-indigo-800">
                                Uredi
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-rose-600 hover:text-rose-800">
                                    Obriši
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">
                            Nema korisnika.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-slate-100 px-4 py-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
