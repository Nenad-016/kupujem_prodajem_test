@php
    $depth = $depth ?? 0;

    $isActive = request()->routeIs('ads.by-category')
        && request()->route('category')
        && request()->route('category')->id === $category->id;

    $totalCount = $category->allAdsCount();
@endphp

<li>
    <a href="{{ route('ads.by-category', $category) }}"
       class="flex items-center justify-between rounded-md px-2 py-1.5
            {{ $isActive ? 'bg-indigo-100 text-indigo-700 font-semibold'
                         : 'text-slate-700 hover:bg-slate-50 hover:text-indigo-600' }}">

        <span class="flex items-center">
            @if($depth > 0)
                <span class="text-slate-300 mr-1">
                    {!! str_repeat('&mdash;', $depth) !!}
                </span>
            @endif

            {{ $category->name }}
        </span>

        <span class="text-xs text-slate-400">
            {{ $totalCount }}
        </span>
    </a>

    @if ($category->children && $category->children->count())
        <ul class="mt-1 ml-3 border-l border-slate-200 pl-2 space-y-1 text-[13px]">
            @foreach ($category->children as $child)
                @include('ads.partials.category-node', [
                    'category' => $child,
                    'depth'    => $depth + 1,
                ])
            @endforeach
        </ul>
    @endif
</li>
