<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private const DEFAULT_PASSWORD = 'Password123!';

    public function index(): View
    {
        $users = User::query()
            ->with([
                'role',
                'department',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.master.users.index',
            compact('users')
        );
    }
    public function create(): View
{
    $roles = Role::query()
        ->orderBy('name')
        ->get();

    $departments = Department::query()
        ->orderBy('name')
        ->get();

    return view(
        'admin.master.users.create',
        compact(
            'roles',
            'departments'
        )
    );
}
public function store(
    Request $request
): RedirectResponse
{
    $agentRoleId = Role::query()
        ->where('name', 'AGENT')
        ->value('id');

    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

        ],

        'email' => [

            'required',

            'email',

            'max:255',

            'unique:users,email',

        ],

        'password' => [

            'required',

            'confirmed',

            'min:8',

        ],

        'role_id' => [

            'required',

            'exists:roles,id',

        ],

        'department_id' => [

            Rule::requiredIf(
                (int) $request->role_id === $agentRoleId
            ),

            'nullable',

            'exists:departments,id',

        ],

        'is_active' => [

            'required',

            'boolean',

        ],

    ]);

    $validated['password'] = Hash::make(
        $validated['password']
    );

    User::create($validated);

    return redirect()
        ->route('admin.users.index')
        ->with(
            'success',
            'User created successfully.'
        );
}

public function edit(
    User $user
): View
{
    $roles = Role::query()
        ->orderBy('name')
        ->get();

    $departments = Department::query()
        ->orderBy('name')
        ->get();

    return view(
        'admin.master.users.edit',
        compact(
            'user',
            'roles',
            'departments'
        )
    );
}

public function update(
    Request $request,
    User $user
): RedirectResponse
{
    $agentRoleId = Role::query()
        ->where('name', 'AGENT')
        ->value('id');

    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

        ],

        'email' => [

            'required',

            'email',

            'max:255',

            Rule::unique('users', 'email')
                ->ignore($user),

        ],

        'role_id' => [

            'required',

            'exists:roles,id',

        ],

        'department_id' => [

            Rule::requiredIf(
                (int) $request->role_id === $agentRoleId
            ),

            'nullable',

            'exists:departments,id',

        ],

        'is_active' => [

            'required',

            'boolean',

        ],

    ]);

    $user->update($validated);

    return redirect()
        ->route('admin.users.index')
        ->with(
            'success',
            'User updated successfully.'
        );
}
public function toggleStatus(
    User $user
): RedirectResponse
{
    if ($user->id === Auth::id()) {

        return back()->with(
            'error',
            'You cannot deactivate your own account.'
        );

    }

    $user->update([

        'is_active' => ! $user->is_active,

    ]);

    return back()->with(
        'success',
        'User status updated successfully.'
    );
}
public function resetPassword(
    User $user
): RedirectResponse
{
    if ($user->id === Auth::id()) {

        return back()->with(
            'error',
            'You cannot reset your own password.'
        );

    }

    $user->update([

        'password' => Hash::make(
            self::DEFAULT_PASSWORD
        ),

    ]);

    return back()->with(
        'success',
        'Password has been reset successfully.'
    );
}

}