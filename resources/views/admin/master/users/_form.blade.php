<x-field label="Name" name="name" :error="$errors->first('name')">
    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name', $user->name ?? '') }}"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        required
    >
</x-field>

<x-field label="Email" name="email" :error="$errors->first('email')">
    <input
        type="email"
        id="email"
        name="email"
        value="{{ old('email', $user->email ?? '') }}"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        required
    >
</x-field>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    <x-field label="Role" name="role_id" :error="$errors->first('role_id')">
        <select
            id="role_id"
            name="role_id"
            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
            required
        >
            <option value="">-- Select Role --</option>
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
    </x-field>

    <x-field id="department-wrapper" label="Department" name="department_id" :error="$errors->first('department_id')">
        <select
            id="department_id"
            name="department_id"
            class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        >
            <option value="">-- Select Department --</option>
            @foreach($departments as $department)
                <option
                    value="{{ $department->id }}"
                    @selected(old('department_id', $user->department_id ?? '') == $department->id)
                >
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </x-field>

</div>

<x-field label="Status" name="is_active" :error="$errors->first('is_active')">
    <select
        name="is_active"
        class="w-full border border-border rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
    >
        <option value="1" @selected(old('is_active', $user->is_active ?? true))>
            Active
        </option>
        <option value="0" @selected(old('is_active', $user->is_active ?? true) == false)>
            Inactive
        </option>
    </select>
</x-field>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role_id');
    const departmentWrapper = document.getElementById('department-wrapper');
    const departmentSelect = document.getElementById('department_id');

    function toggleDepartment() {

        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        const role = selectedOption.dataset.role;

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
    roleSelect.addEventListener('change', toggleDepartment);

});
</script>
@endpush