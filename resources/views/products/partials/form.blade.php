<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mt-5 space-y-4">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    @if(isset($page))<input type="hidden" name="page" value="{{ old('page', $page) }}">@endif

    <div><label class="zz-label">اسم الصنف</label><input class="zz-input" name="name" value="{{ old('name', $product?->name) }}" placeholder="مثال: برجر دبل" required></div>

    <div><label class="zz-label">القسم</label>
        <select class="zz-input" name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>{{ $category->name_ar }}</option>
            @endforeach
        </select>
    </div>

    <div><label class="zz-label">وصف الصنف</label><textarea class="zz-input" name="description" rows="4" placeholder="وصف بسيط يوضح المكونات أو الحجم">{{ old('description', $product?->description) }}</textarea></div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div><label class="zz-label">السعر</label><input type="number" step="0.01" min="0" class="zz-input" name="price" value="{{ old('price', $product?->price) }}" required></div>
        <div><label class="zz-label">الترتيب</label><input type="number" min="0" class="zz-input" name="sort_order" value="{{ old('sort_order', $product?->sort_order) }}"></div>
    </div>

    <div><label class="zz-label">صورة الصنف</label><input type="file" class="zz-input" name="image" accept="image/*"></div>
    @if($product?->image_path)<img src="{{ asset('storage/'.$product->image_path) }}" class="h-28 w-28 rounded-2xl object-cover" alt="{{ $product->name }}">@endif

    <div class="flex flex-wrap gap-6 text-sm font-semibold text-[#2f3a2f]">
        <label class="flex items-center gap-2"><input type="checkbox" class="zz-checkbox" name="is_available" value="1" {{ old('is_available', $product?->is_available ?? true) ? 'checked' : '' }}> متاح للعرض</label>
        <label class="flex items-center gap-2"><input type="checkbox" class="zz-checkbox" name="is_featured" value="1" {{ old('is_featured', $product?->is_featured ?? false) ? 'checked' : '' }}> صنف مميز</label>
    </div>

    <div class="flex gap-2">
        <button class="zz-btn-primary">حفظ الصنف</button>
        <a href="{{ route('products.index', isset($page) ? ['page' => $page] : []) }}" class="zz-btn-secondary">رجوع</a>
    </div>
</form>
