@props([
    'user',
    'size' => 'md',
    'class' => '',
])

@php
    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];

    $initial = $user?->avatar_initial ?? 'U';

    $isAdmin = isset($user->role) && $user->role === 'admin';

    $bgClass = $isAdmin
        ? 'bg-red-600'
        : 'bg-indigo-600';
@endphp

<div class="rounded-full {{ $bgClass }} text-white flex items-center justify-center font-semibold {{ $sizeClasses }} {{ $class }}">
    {{ $initial }}
</div>
