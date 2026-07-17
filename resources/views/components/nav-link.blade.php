@props([
    'href' => '#',
    'active' => false,
    'icon' => null,
    'soon' => false,
])

@if($soon)

    <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-300 select-none">
        @if($icon)
            <x-icon :name="$icon" />
        @endif
        <span class="flex-1">{{ $slot }}</span>
        <span class="text-[10px] font-medium uppercase tracking-wide bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded">
            Soon
        </span>
    </div>

@else

    <a href="{{ $href }}"
       class="group flex items-center gap-3 pl-2.5 pr-3 py-2 rounded-lg text-sm font-medium border-l-[3px] transition-colors
       {{ $active
            ? 'bg-accent-tint border-accent text-accent-hover'
            : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

        @if($icon)
            <span class="{{ $active ? 'text-accent' : 'text-slate-400 group-hover:text-slate-500' }}">
                <x-icon :name="$icon" />
            </span>
        @endif

        <span>{{ $slot }}</span>
    </a>

@endif