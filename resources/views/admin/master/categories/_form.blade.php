
<div class="mb-4">

    <label class="block mb-2 font-medium">

        Category Name

    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $category->name ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required
    >

    @error('name')

        <p class="text-red-500 text-sm mt-1">

            {{ $message }}

        </p>

    @enderror

<label class="block mb-2 font-medium">

        Category Description

    </label>

    <input
        type="text"
        name="description"
        value="{{ old('description', $category->description ?? '') }}"
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
        href="{{ route('admin.categories.index') }}"
        class="border px-4 py-2 rounded"
    >
        Cancel
    </a>

</div>