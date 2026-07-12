<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
public function index(): View
    {
        $departments = Department::query()
            ->latest()
            ->paginate(10);

        return view(
            'admin.master.departments.index',
            compact('departments')
        );
    }


    public function create(): View
    {
        return view(
            'admin.master.departments.create'
        );
    }

public function store(
    Request $request
): RedirectResponse
{
    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

            'unique:departments,name',

        ],
        'description' => [

            'nullable',

            'string',

        ],

    ]);

    Department::create($validated);

    return redirect()
        ->route('admin.departments.index')
        ->with(
            'success',
            'Department created successfully.'
        );
}

    public function edit(
    Department $department
    ): View
    {
        return view(
            'admin.master.departments.edit',
            compact('department')
        );
    }

    public function update(
    Request $request,
    Department $department
): RedirectResponse
{
    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

            Rule::unique('departments', 'name')
                ->ignore($department),

        ],
        'description' => [

            'nullable',

            'string',

        ],

    ]);

    $department->update($validated);

    return redirect()
        ->route('admin.departments.index')
        ->with(
            'success',
            'Department updated successfully.'
        );
}

public function destroy(
    Department $department
): RedirectResponse
{
    if (
        $department->users()->exists() ||
        $department->tickets()->exists()
    ) {

        return redirect()
            ->route('admin.departments.index')
            ->with(
                'error',
                'Department cannot be deleted because it is still in use.'
            );

    }

    $department->delete();

    return redirect()
        ->route('admin.departments.index')
        ->with(
            'success',
            'Department deleted successfully.'
        );
}
}