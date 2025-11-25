<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Registracija | Mali oglasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN (kao i na login strani) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 flex flex-col">

    {{-- Gornja traka sa linkom nazad na početnu --}}
    <header class="w-full border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold">
                    MO
                </span>
                <span class="text-sm font-semibold tracking-tight text-slate-900">
                    Mali oglasi
                </span>
            </div>

            <a href="{{ route('home') }}"
               class="text-xs sm:text-sm font-medium text-slate-600 hover:text-indigo-600">
                ← Nazad na početnu
            </a>
        </div>
    </header>

    {{-- Glavni sadržaj --}}
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 py-10 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                {{-- Leva strana – tekst / “hero” --}}
                <div class="space-y-6">
                    <p class="text-xs font-semibold tracking-wide text-indigo-600 uppercase">
                        NOVI NALOG
                    </p>

                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                        Mali oglasi – jednostavno, brzo,<br class="hidden sm:block"> jasno.
                    </h1>

                    <p class="text-sm leading-relaxed text-slate-600 max-w-xl">
                        Napravi nalog kako bi mogao da postavljaš, uređuješ i brišeš svoje oglase.
                        Admin ima potpunu kontrolu nad kategorijama i sadržajem, a ti svoj lični panel
                        za brzu objavu.
                    </p>

                    <ul class="space-y-2 text-sm text-slate-700">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-bold">1</span>
                            <span>Brzo postavljanje oglasa sa slikom, cenom i lokacijom.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-bold">2</span>
                            <span>Kategorizacija i pretraga po lokaciji, ceni i stanju.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-bold">3</span>
                            <span>Lični panel za sopstvene oglase i brze izmene.</span>
                        </li>
                    </ul>
                </div>

                {{-- Desna strana – forma za registraciju --}}
                <div>
                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 sm:p-8 max-w-md ml-auto">
                        <h2 class="text-xl font-semibold text-slate-900 mb-1">
                            Registracija
                        </h2>
                        <p class="text-xs text-slate-500 mb-6">
                            Napravi nalog i započni sa postavljanjem oglasa.
                        </p>

                        {{-- Status / greške ako koristiš Breeze komponente --}}
                        @if (session('status'))
                            <div class="mb-4 text-sm text-emerald-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 text-sm text-rose-600">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            {{-- Ime i prezime --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">
                                    Ime i prezime
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">
                                    Email adresa
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            {{-- Lozinka --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">
                                    Lozinka
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            {{-- Potvrda lozinke --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">
                                    Potvrda lozinke
                                </label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <button
                                type="submit"
                                class="mt-2 w-full inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                            >
                                Registruj se
                            </button>

                            <p class="mt-3 text-xs text-center text-slate-500">
                                Već imaš nalog?
                                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                                    Prijavi se
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 py-4 text-xs text-slate-500 flex justify-between">
            <span>© {{ date('Y') }} Mali oglasi.</span>
            <span>Test zadatak – Laravel.</span>
        </div>
    </footer>
</body>
</html>
