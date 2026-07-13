@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <h1 class="text-2xl font-bold">

        Users

    </h1>

    <a
        href="{{ route('admin.users.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Create User
    </a>

</div>

@if($users->isEmpty())

<div class="border rounded p-6">

    No users found.

</div>

@else

<table class="w-full border-collapse">

    <thead>

        <tr class="border-b">

            <th class="text-left p-3">

                Name

            </th>

            <th class="text-left p-3">

                Email

            </th>

            <th class="text-left p-3">

                Role

            </th>

            <th class="text-left p-3">

                Department

            </th>

            <th class="text-center p-3">

                Status

            </th>

            <th class="text-center p-3">

                Action

            </th>

        </tr>

    </thead>

    <tbody>

    @foreach($users as $user)

        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">

                {{ $user->name }}

            </td>

            <td class="p-3">

                {{ $user->email }}

            </td>

            <td class="p-3">

                {{ $user->role->name }}

            </td>

            <td class="p-3">

                {{ $user->department?->name ?? '-' }}

            </td>

            <td class="p-3 text-center">

                @if($user->is_active)

                    <span class="text-green-600 font-semibold">

                        Active

                    </span>

                @else

                    <span class="text-red-600 font-semibold">

                        Inactive

                    </span>

                @endif

            </td>

            <td class="p-3 text-center">

                <a
                    href="{{ route('admin.users.edit', $user) }}"
                    class="text-yellow-600 hover:underline"
                >
                    Edit
                </a>

                |

                <form
                    action="{{ route('admin.users.toggle-status', $user) }}"
                    method="POST"
                    class="inline"
                >

                    @csrf

                    @method('PATCH')

                    <button
                        class="text-blue-600 hover:underline"
                    >

                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}

                    </button>

                </form>

                |

                <form
                    action="{{ route('admin.users.reset-password', $user) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Reset this user password?')"
                >

                    @csrf

                    @method('PATCH')

                    <button
                        class="text-red-600 hover:underline"
                    >

                        Reset Password

                    </button>

                </form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<div class="mt-6">

    {{ $users->links() }}

</div>

@endif

@endsection