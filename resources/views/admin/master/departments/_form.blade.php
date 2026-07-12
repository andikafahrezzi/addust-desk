
<div class="mb-4">

    <label class="block mb-2 font-medium">

        Department Name

    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $department->name ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required
    >

    @error('name')

        <p class="text-red-500 text-sm mt-1">

            {{ $message }}

        </p>

    @enderror

<label class="block mb-2 font-medium">

        Department Description

    </label>

    <input
        type="text"
        name="description"
        value="{{ old('description', $department->description ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required 
    >

    @error('description')

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
        href="{{ route('admin.departments.index') }}"
        class="border px-4 py-2 rounded"
    >
        Cancel
    </a>

</div>