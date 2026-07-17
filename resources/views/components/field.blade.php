@props(['label', 'name', 'error' => null])

<div class="mb-5">

    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
        {{ $label }}
    </label>

    {{ $slot }}

    @if($error)
        <p class="text-rose-600 text-xs mt-1.5">
            {{ $error }}
        </p>
    @endif

</div>