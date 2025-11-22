{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <h2 class="text-xl font-semibold text-slate-900 mb-1">Registracija</h2>
    <p class="text-sm text-slate-500 mb-6">
        Napravi nalog i započni sa postavljanjem oglasa.
    </p>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">
                Ime i prezime
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">
                Email adresa
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">
                Lozinka
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">
                Potvrda lozinke
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            Registruj se
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        Već imaš nalog?
        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
            Prijavi se
        </a>
    </div>
</x-guest-layout>
