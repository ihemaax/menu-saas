<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mt-6 space-y-6">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <section class="grid gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <label class="zz-label">اسم المنتج</label>
            <input class="zz-input" name="name" value="{{ old('name', $product?->name) }}" required>
        </div>

        <div>
            <label class="zz-label">القسم</label>
            <select class="zz-input" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>{{ $category->name_ar }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="zz-label">الترتيب</label>
            <input type="number" min="0" class="zz-input" name="sort_order" value="{{ old('sort_order', $product?->sort_order) }}">
        </div>

        <div class="md:col-span-2">
            <label class="zz-label">الوصف</label>
            <textarea class="zz-input" name="description" rows="4">{{ old('description', $product?->description) }}</textarea>
        </div>

        <div>
            <label class="zz-label">السعر</label>
            <input type="number" step="0.01" min="0" class="zz-input" name="price" value="{{ old('price', $product?->price) }}" required>
        </div>

        <div>
            <label class="zz-label">صورة المنتج</label>
            <input type="file" class="zz-input" name="image" accept="image/*">
        </div>

        @if($product?->image_path)
            <div class="md:col-span-2">
                <p class="text-xs font-semibold text-slate-500">الصورة الحالية</p>
                <img src="{{ asset('storage/'.$product->image_path) }}" class="mt-2 h-32 w-32 rounded-2xl object-cover" alt="{{ $product->name }}">
            </div>
        @endif
    </section>

    <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
        <p class="text-sm font-bold text-slate-900">خيارات العرض</p>
        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input class="zz-checkbox" type="checkbox" name="is_available" value="1" {{ old('is_available', $product?->is_available ?? true) ? 'checked' : '' }}>
                متاح للطلب
            </label>
            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input class="zz-checkbox" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product?->is_featured ?? false) ? 'checked' : '' }}>
                منتج مميز
            </label>
        </div>
    </section>

    <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
        <a href="{{ route('products.index') }}" class="zz-btn-secondary">إلغاء</a>
        <button class="zz-btn-primary">حفظ المنتج</button>
    </div>
</form>
