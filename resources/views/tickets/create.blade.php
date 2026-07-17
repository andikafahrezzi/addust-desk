@extends('layouts.app')

@section('title', 'Create Ticket · AddustDesk')
@section('page-title', 'Create Ticket')
@section('page-subtitle', 'Jelaskan kendala kamu, tim IT akan segera menindaklanjuti.')

@section('page-actions')
    <a href="{{ route('user.tickets.index') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-border text-slate-600 text-sm font-medium hover:bg-slate-50 transition-colors">
        Cancel
    </a>
@endsection

@section('content')

    <div class="max-w-2xl">

        <div class="bg-white border border-border rounded-xl p-6">

            <form action="{{ route('user.tickets.store') }}" method="POST">
                @csrf

                {{-- Title --}}
                <x-field label="Title" name="title" :error="$errors->first('title')">
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Ringkas masalahmu dalam satu kalimat"
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
                    >
                </x-field>

                {{-- Category & Priority --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <x-field label="Category" name="category_id" :error="$errors->first('category_id')">
                        <select
                            id="category_id"
                            name="category_id"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
                        >
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </x-field>

                    <x-field label="Priority" name="priority_id" :error="$errors->first('priority_id')">
                        <select
                            id="priority_id"
                            name="priority_id"
                            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
                        >
                            <option value="">-- Select Priority --</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" @selected(old('priority_id') == $priority->id)>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </x-field>

                </div>

                {{-- Description --}}
                <x-field label="Description" name="description" :error="$errors->first('description')">
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        placeholder="Jelaskan kendala secara detail: apa yang terjadi, sejak kapan, dan langkah apa yang sudah kamu coba."
                        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent resize-none"
                    >{{ old('description') }}</textarea>
                </x-field>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-border mt-6">
                    <a href="{{ route('user.tickets.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
                        <x-icon name="check" class="w-4 h-4" />
                        Create Ticket
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection