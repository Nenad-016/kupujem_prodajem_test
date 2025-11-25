@php
    $maxDepth = 4;
@endphp

<li>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @if($depth > 0)
                <span class="text-slate-300 mr-1">
                    {!! str_repeat('&mdash;', $depth) !!}
                </span>
            @endif

            <span class="text-slate-700">
                {{ $category->name }}
            </span>
        </div>

        <span class="text-xs text-slate-500 ml-2">
            {{ $category->allAdsCount() }}
        </span>
    </div>

    @if($depth < $maxDepth && $category->children && $category->children->count())
        <ul class="mt-1 ml-3 space-y-1">
            @foreach($category->children as $child)
                @include('admin.partials.category-node', [
                    'category' => $child,
                    'depth' => $depth + 1,
                ])
            @endforeach
        </ul>
    @endif
</li>
