<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $restaurant = auth()->user()->restaurant;

        return view('categories.index', [
            'categories' => $restaurant->categories()->latest('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $restaurant = $request->user()->restaurant;

        Category::create([
            'restaurant_id' => $restaurant->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'sort_order' => $request->integer('sort_order') ?: ((int) $restaurant->categories()->max('sort_order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('categories.index')->with('success', 'القسم اتضاف بنجاح.');
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'sort_order' => $request->integer('sort_order') ?: $category->sort_order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'تعديلات القسم اتحفظت.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'القسم اتمسح من المنيو.');
    }
}
