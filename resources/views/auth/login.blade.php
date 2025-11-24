<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Prijava | Mali oglasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">

    {{-- NAVBAR (samo logo + link ka početnoj) --}}
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold">
                    MO
                </span>
                <span class="text-lg font-semibold tracking-tight">
                    Mali oglasi
                </span>
            </a>

            <a href="{{ route('home') }}" class="text-xs sm:text-sm text-slate-600 hover:text-indigo-600">
                ← Nazad na početnu
            </a>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid gap-10 lg:grid-cols-2 items-center">

            <section class="space-y-6">
                <p class="text-xs font-semibold tracking-wide text-indigo-600 uppercase">
                    Dobrodošli nazad
                </p>
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                    Mali oglasi – jednostavno, brzo, jasno.
                </h1>

                <p class="text-sm sm:text-base text-slate-600 max-w-md">
                    Registruj se ili se prijavi da bi postavljao, uređivao i brisao svoje oglase.
                    Admin ima potpunu kontrolu nad kategorijama i sadržajem, a ti svoj lični panel
                    za brzu objavu.
                </p>

                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-5 w-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold">1</span>
                        <span>Brzo postavljanje oglasa sa slikom, cenom i lokacijom.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-5 w-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold">2</span>
                        <span>Kategorizacija i pretraga po lokaciji, ceni i stanju.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-5 w-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold">3</span>
                        <span>Poseban admin panel za uređivanje sistema.</span>
                    </li>
                </ul>

                <p class="text-xs text-slate-400">
                    Savet: koristi istu email adresu za prijavu i kontakt u oglasima, da bi te kupci lakše našli.
                </p>
            </section>

            <section>
                <div class="bg-white shadow-sm border border-slate-200 rounded-2xl px-6 py-6 sm:px-8 sm:py-8">
                    <h2 class="text-xl font-semibold text-slate-900 mb-1">
                        Prijava
                    </h2>
                    <p class="text-sm text-slate-500 mb-6">
                        Uloguj se da bi mogao da postavljaš i uređuješ svoje oglase.
                    </p>

                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-200 px-3 py-2 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- VALIDACIONE GREŠKE --}}
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-3 py-2 text-sm text-rose-700">
                            <p class="font-semibold mb-1">Došlo je do greške:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-600 mb-1">
                                Email adresa
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        {{-- Lozinka --}}
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-600 mb-1">
                                Lozinka
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        {{-- Zapamti me + Zaboravljena lozinka --}}
                        <div class="flex items-center justify-between text-xs text-slate-600">
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                <span>Zapamti me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-700">
                                    Zaboravljena lozinka?
                                </a>
                            @endif
                        </div>

                        {{-- Dugme Prijavi se --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 focus:ring-offset-white"
                            >
                                Prijavi se
                            </button>
                        </div>
                    </form>

                    {{-- Link ka registraciji --}}
                    <p class="mt-6 text-xs text-center text-slate-500">
                        Nemaš nalog?
                        <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-700">
                            Registruj se
                        </a>
                    </p>
                </div>
            </section>
        </div>
    </main>

    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 py-4 text-xs text-slate-500 flex justify-between">
            <span>© {{ date('Y') }} Mali oglasi.</span>
            <span>Test zadatak – Laravel.</span>
        </div>
    </footer>
</body>
</html>
