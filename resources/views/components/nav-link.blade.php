{{--
    Simpan file ini di: resources/views/components/nav-link.blade.php
    Dipakai di sidebar sebagai: <x-nav-link :route="'dashboard'" label="Dashboard"> ...svg path... </x-nav-link>
--}}

@props(['route', 'label'])

@php
    $active = request()->routeIs($route) || request()->routeIs($route . '.*');
@endphp

<a
    href="{{ route($route) }}"
    class="group flex items-center gap-3 px-4 py-2.5 rounded-full text-sm font-medium font-[Inter] transition-all duration-200 ease-out
        {{ $active
            ? 'bg-gradient-to-r from-[#0EA5E9] to-[#0284C7] text-white shadow-[0_10px_20px_-8px_rgba(14,165,233,0.55)]'
            : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F] hover:-translate-y-0.5' }}"
>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 shrink-0 transition-colors {{ $active ? 'text-white' : 'text-[#5B7587] group-hover:text-[#0EA5E9]' }}"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.8"
        stroke="currentColor"
    >
        {{ $slot }}
    </svg>
    <span>{{ $label }}</span>
</a>
