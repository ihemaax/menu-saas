<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $restaurant = auth()->user()->restaurant;

        $products = $restaurant->products()
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $restaurant = auth()->user()->restaurant;
        $categories = $restaurant->categories()->where('is_active', true)->orderBy('sort_order')->get();

        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $restaurant = $request->user()->restaurant;

        abort_unless($restaurant->categories()->whereKey($request->integer('category_id'))->exists(), 403);

        Product::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $request->integer('category_id'),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $request->file('image')?->store('products/images', 'public'),
            'sort_order' => $request->integer('sort_order') ?: ((int) $restaurant->products()->max('sort_order') + 1),
            'is_available' => $request->boolean('is_available', true),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('products.index')->with('success', 'الصنف اتضاف بنجاح.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $categories = auth()->user()->restaurant->categories()->where('is_active', true)->orderBy('sort_order')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        abort_unless(
            $request->user()->restaurant->categories()->whereKey($request->integer('category_id'))->exists(),
            403
        );

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products/images', 'public');
        }

        $product->update([
            'category_id' => $request->integer('category_id'),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'sort_order' => $request->integer('sort_order') ?: $product->sort_order,
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('products.index')->with('success', 'تعديلات الصنف اتحفظت.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'الصنف اتمسح من المنيو.');
    }
}
