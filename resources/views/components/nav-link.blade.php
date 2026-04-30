@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 border-l-4 border-[#4F8EF7] bg-[#4F8EF7]/10 text-[#4F8EF7] font-bold py-3 px-6 transition-all duration-200 scale-98 active:scale-95'
            : 'flex items-center gap-4 text-slate-400 py-3 px-6 hover:text-slate-100 hover:bg-slate-800/50 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="material-symbols-outlined">{{ $icon }}</span>
    <span class="font-label-caps">{{ $slot }}</span>
</a>
