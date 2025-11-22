@if (session('success'))
    <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-100 px-4 py-2 text-sm text-emerald-800">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-md bg-rose-50 border border-rose-100 px-4 py-2 text-sm text-rose-800">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 rounded-md bg-amber-50 border border-amber-100 px-4 py-2 text-sm text-amber-900">
        {{ session('warning') }}
    </div>
@endif
