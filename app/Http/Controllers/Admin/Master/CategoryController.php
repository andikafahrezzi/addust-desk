<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
public function index(): View
    {
        $categories = Category::query()
            ->latest()
            ->paginate(10);

        return view(
            'admin.master.categories.index',
            compact('categories')
        );
    }


    public function create(): View
    {
        return view(
            'admin.master.categories.create'
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

            'unique:categories,name',

        ],
        'description' => [

            'nullable',

            'string',

        ],

    ]);

    Category::create($validated);

    return redirect()
        ->route('admin.categories.index')
        ->with(
            'success',
            'Category created successfully.'
        );
}

    public function edit(
    Category $category
    ): View
    {
        return view(
            'admin.master.categories.edit',
            compact('category')
        );
    }

    public function update(
    Request $request,
    Category $category
): RedirectResponse
{
    $validated = $request->validate([

        'name' => [

            'required',

            'string',

            'max:255',

            Rule::unique('categories', 'name')
                ->ignore($category),

        ],
        'description' => [

            'nullable',

            'string',

        ],

    ]);

    $category->update($validated);

    return redirect()
        ->route('admin.categories.index')
        ->with(
            'success',
            'Category updated successfully.'
        );
}

public function destroy(
    Category $category
): RedirectResponse
{
    if (
        $category->tickets()->exists()
    ) {

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'error',
                'Category cannot be deleted because it is still in use.'
            );

    }

    $category->delete();

    return redirect()
        ->route('admin.categories.index')
        ->with(
            'success',
            'Category deleted successfully.'
        );
}
}