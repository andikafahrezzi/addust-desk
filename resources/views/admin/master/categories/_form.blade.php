<x-field label="Category Name" name="name" :error="$errors->first('name')">
    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name', $category->name ?? '') }}"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        required
    >
</x-field>

<x-field label="Category Description" name="description" :error="$errors->first('description')">
    <input
        type="text"
        id="description"
        name="description"
        value="{{ old('description', $category->description ?? '') }}"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        required
    >
</x-field>

<div class="flex items-center justify-end gap-3 pt-4 mt-2 border-t border-border">

    <a href="{{ route('admin.categories.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
        Cancel
    </a>

    <button type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
        <x-icon name="check" class="w-4 h-4" />
        Save
    </button>

</div>