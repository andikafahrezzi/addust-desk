
<div class="mb-4">

    <label class="block mb-2 font-medium">

        Priority Name

    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $priority->name ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required
    >

    @error('name')

        <p class="text-red-500 text-sm mt-1">

            {{ $message }}

        </p>

    @enderror

<label class="block mb-2 font-medium">

        SLA Response Minutes

    </label>

    <input
        type="number"
        name="sla_response_minutes"
        value="{{ old('sla_response_minutes', $priority->sla_response_minutes ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required 
    >

    @error('sla_response_minutes')

        <p class="text-red-500 text-sm mt-1">

            {{ $message }}

        </p>

    @enderror

    <label class="block mb-2 font-medium">

    SLA Resolution Minutes
    </label>

    <input
        type="number"
        name="sla_resolution_minutes"
        value="{{ old('sla_resolution_minutes', $priority->sla_resolution_minutes ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required 
    >

    @error('sla_resolution_minutes')

        <p class="text-red-500 text-sm mt-1">

            {{ $message }}

        </p>

    @enderror
</div>

<div class="flex gap-3">

    <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Save
    </button>

    <a
        href="{{ route('admin.priorities.index') }}"
        class="border px-4 py-2 rounded"
    >
        Cancel
    </a>

</div>