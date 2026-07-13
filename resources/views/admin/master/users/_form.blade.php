<div class="space-y-5">

    {{-- Name --}}
    <div>

        <label class="block mb-2 font-medium">
            Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name ?? '') }}"
            class="w-full border rounded px-3 py-2"
            required
        >

        @error('name')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Email --}}
    <div>

        <label class="block mb-2 font-medium">
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email', $user->email ?? '') }}"
            class="w-full border rounded px-3 py-2"
            required
        >

        @error('email')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Role --}}
    <div>

        <label class="block mb-2 font-medium">
            Role
        </label>

        <select
            id="role_id"
            name="role_id"
            class="w-full border rounded px-3 py-2"
            required
        >

            <option value="">
                -- Select Role --
            </option>

            @foreach($roles as $role)

                <option
                    value="{{ $role->id }}"
                    data-role="{{ strtoupper($role->name) }}"
                    @selected(old('role_id', $user->role_id ?? '') == $role->id)
                >
                    {{ $role->name }}
                </option>

            @endforeach

        </select>

        @error('role_id')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Department --}}
    <div id="department-wrapper">

        <label class="block mb-2 font-medium">
            Department
        </label>

        <select
            id="department_id"
            name="department_id"
            class="w-full border rounded px-3 py-2"
        >

            <option value="">
                -- Select Department --
            </option>

            @foreach($departments as $department)

                <option
                    value="{{ $department->id }}"
                    @selected(old('department_id', $user->department_id ?? '') == $department->id)
                >
                    {{ $department->name }}
                </option>

            @endforeach

        </select>

        @error('department_id')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Status --}}
    <div>

        <label class="block mb-2 font-medium">
            Status
        </label>

        <select
            name="is_active"
            class="w-full border rounded px-3 py-2"
        >

            <option
                value="1"
                @selected(old('is_active', $user->is_active ?? true))
            >
                Active
            </option>

            <option
                value="0"
                @selected(old('is_active', $user->is_active ?? true) == false)
            >
                Inactive
            </option>

        </select>

        @error('is_active')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role_id');

    const departmentWrapper = document.getElementById('department-wrapper');

    const departmentSelect = document.getElementById('department_id');

    function toggleDepartment() {

        const selectedOption =
            roleSelect.options[roleSelect.selectedIndex];

        const role =
            selectedOption.dataset.role;

        if (role === 'AGENT') {

            departmentWrapper.style.display = '';

            departmentSelect.required = true;

        } else {

            departmentWrapper.style.display = 'none';

            departmentSelect.required = false;

            departmentSelect.value = '';

        }

    }

    toggleDepartment();

    roleSelect.addEventListener(
        'change',
        toggleDepartment
    );

});

</script>