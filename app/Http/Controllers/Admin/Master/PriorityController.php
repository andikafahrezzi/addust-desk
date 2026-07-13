<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PriorityController extends Controller
{
public function index(): View
    {
        $priorities = Priority::query()
            ->latest()
            ->paginate(10);

        return view(
            'admin.master.priorities.index',
            compact('priorities')
        );
    }


    public function create(): View
    {
        return view(
            'admin.master.priorities.create'
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

            'unique:priorities,name',

        ],

        'sla_response_minutes' => [

        'required',

        'integer',

        'min:1',

        ],

        'sla_resolution_minutes' => [

            'required',

            'integer',

            'min:1',

        ],

    ]);

    Priority::create($validated);

    return redirect()
        ->route('admin.priorities.index')
        ->with(
            'success',
            'Priority created successfully.'
        );
}

    public function edit(
    Priority $priority
    ): View
    {
        return view(
            'admin.master.priorities.edit',
            compact('priority')
        );
    }

    public function update(
    Request $request,
    Priority $priority
): RedirectResponse
{
    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

            Rule::unique('priorities', 'name')
                ->ignore($priority),

        ],
        'sla_response_minutes' => [

            'required',

            'integer',

            'min:1',

        ],
        'sla_resolution_minutes' => [

            'required',

            'integer',

            'min:1',

        ],

    ]);

    $priority->update($validated);

    return redirect()
        ->route('admin.priorities.index')
        ->with(
            'success',
            'Priority updated successfully.'
        );
}

public function destroy(
    Priority $priority
): RedirectResponse
{
    if (
        $priority->tickets()->exists()
    ) {

        return redirect()
            ->route('admin.priorities.index')
            ->with(
                'error',
                'Priority cannot be deleted because it is still in use.'
            );

    }

    $priority->delete();

    return redirect()
        ->route('admin.priorities.index')
        ->with(
            'success',
            'Priority deleted successfully.'
        );
}
}