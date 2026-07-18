@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Edit User

</h1>

<form
    action="{{ route('admin.users.update', $user) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    @include('admin.master.users._form')

    <div class="flex items-center justify-end gap-3 pt-4 mt-2 border-t border-border">

    <a href="{{ route('admin.users.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
        Cancel
    </a>

    <button type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
        <x-icon name="check" class="w-4 h-4" />
        Save
    </button>

</div>

</form>

@endsection