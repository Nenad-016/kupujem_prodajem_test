{{-- resources/views/layouts/front.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Mali oglasi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- (opciono) tvoj dodatni CSS ako imaš nešto custom u public/css/app.css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">

    {{-- HEADER / NAVBAR --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold">
                    MO
                </span>
                <span class="text-lg font-semibold tracking-tight">
                    Mali oglasi
                </span>
            </a>

            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-indigo-600">
                    Početna
                </a>

                @auth
                    <a href="{{ route('ads.my') }}" class="text-slate-700 hover:text-indigo-600">
                        Moji oglasi
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.categories.index') }}" class="text-slate-700 hover:text-indigo-600">
                            Admin panel
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                        >
                            Odjava
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="text-slate-700 hover:text-indigo-600 text-sm"
                    >
                        Prijava
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700"
                    >
                        Registracija
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- GLAVNI LAYOUT: SIDEBAR + CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[260px,1fr]">
            <aside>
                @yield('sidebar')
            </aside>

            <section>
                @yield('content')
            </section>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white mt-8">
        <div class="max-w-7xl mx-auto px-4 py-4 text-xs text-slate-500 flex justify-between">
            <span>© {{ date('Y') }} Mali oglasi.</span>
            <span>Test zadatak – Laravel.</span>
        </div>
    </footer>

</body>
</html>
