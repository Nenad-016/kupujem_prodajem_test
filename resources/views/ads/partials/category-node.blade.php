@php
    $isActive = request()->routeIs('ads.by-category')
        && request()->route('category')
        && request()->route('category')->id === $category->id;
@endphp

<li>
    <a href="{{ route('ads.by-category', $category) }}"
       class="flex items-center justify-between rounded-md px-2 py-1.5
            @if($isActive)
                bg-indigo-100 text-indigo-700 font-semibold
            @else
                text-slate-700 hover:bg-slate-50 hover:text-indigo-600
            @endif">
        <span>{{ $category->name }}</span>

        @if (isset($category->ads_count))
            <span class="text-xs text-slate-400">{{ $category->ads_count }}</span>
        @endif
    </a>

    @if ($category->children && $category->children->count())
        <ul class="mt-1 ml-3 border-l border-slate-200 pl-2 space-y-1 text-[13px]">
            @foreach ($category->children as $child)
                @include('ads.partials.category-node', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
