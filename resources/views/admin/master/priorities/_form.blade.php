<x-field label="Priority Name" name="name" :error="$errors->first('name')">
    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name', $priority->name ?? '') }}"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        required
    >
</x-field>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    <x-field label="SLA Response Minutes" name="sla_response_minutes" :error="$errors->first('sla_response_minutes')">
        <input
            type="number"
            id="sla_response_minutes"
            name="sla_response_minutes"
            value="{{ old('sla_response_minutes', $priority->sla_response_minutes ?? '') }}"
            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
            required
        >
    </x-field>

    <x-field label="SLA Resolution Minutes" name="sla_resolution_minutes" :error="$errors->first('sla_resolution_minutes')">
        <input
            type="number"
            id="sla_resolution_minutes"
            name="sla_resolution_minutes"
            value="{{ old('sla_resolution_minutes', $priority->sla_resolution_minutes ?? '') }}"
            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
            required
        >
    </x-field>

</div>

<div class="flex items-center justify-end gap-3 pt-4 mt-2 border-t border-border">

    <a href="{{ route('admin.priorities.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
        Cancel
    </a>

    <button type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
        <x-icon name="check" class="w-4 h-4" />
        Save
    </button>

</div>