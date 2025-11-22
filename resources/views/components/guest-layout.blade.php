{{-- resources/views/components/guest-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Mali oglasi - Prijava' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">

    <div class="w-full max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8 items-center">

            <div class="hidden md:flex flex-col gap-4">
                <h1 class="text-3xl font-bold text-slate-900">
                    Mali oglasi – jednostavno, brzo, jasno.
                </h1>
                <p class="text-slate-600">
                    Registruj se da bi mogao da postavljaš i uređuješ svoje oglase.
                    Admin ima poseban panel za upravljanje kategorijama i korisnicima.
                </p>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Brzo postavljanje oglasa</li>
                    <li>• Pretraga po kategoriji, ceni i lokaciji</li>
                    <li>• Odvojene uloge za korisnike i administratore</li>
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-8 border border-slate-100">
                {{ $slot }}
            </div>

        </div>
    </div>

</body>
</html>
