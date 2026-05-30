<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    @if(isset($page))<input type="hidden" name="page" value="{{ old('page', $page) }}">@endif

    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-black text-[#12221d]">اسم الصنف</label>
            <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="name" value="{{ old('name', $product?->name) }}" placeholder="مثال: برجر دبل" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-black text-[#12221d]">القسم</label>
            <select class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>{{ $category->name_ar }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-black text-[#12221d]">وصف الصنف</label>
        <textarea class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="description" rows="4" placeholder="اكتب المكونات أو الحجم أو أي تفاصيل تهم العميل">{{ old('description', $product?->description) }}</textarea>
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-black text-[#12221d]">السعر</label>
            <input type="number" step="0.01" min="0" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="price" value="{{ old('price', $product?->price) }}" required>
        </div>
        <div>
            <label class="mb-2 block text-sm font-black text-[#12221d]">السعر بعد الخصم</label>
            <input type="number" step="0.01" min="0" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="discount_price" value="{{ old('discount_price', $product?->discount_price) }}" placeholder="اختياري">
            <p class="mt-2 text-xs font-bold text-[#68766d]">اتركه فاضي لو مفيش خصم.</p>
            @error('discount_price')
                <p class="mt-2 text-xs font-black text-[#b84d3a]">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="mb-2 block text-sm font-black text-[#12221d]">ترتيب الظهور</label>
            <input type="number" min="0" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="sort_order" value="{{ old('sort_order', $product?->sort_order) }}">
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-black text-[#12221d]">صورة الصنف</label>
        <input type="file" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none file:ml-4 file:rounded-xl file:border-0 file:bg-[#12221d] file:px-4 file:py-2 file:text-sm file:font-black file:text-white" name="image" accept="image/*">
    </div>

    @if($product?->image_path)
        <img src="{{ asset('storage/'.$product->image_path) }}" class="h-32 w-32 rounded-3xl object-cover shadow-[0_14px_34px_rgba(33,43,37,0.12)]" alt="{{ $product->name }}">
    @endif

    <div class="grid gap-3 sm:grid-cols-2">
        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#dce4d8] bg-[#fbf9f4] p-4 text-sm font-black text-[#12221d]">
            <input type="checkbox" class="h-4 w-4 rounded border-[#cdd6ca] text-[#2f7f79] focus:ring-[#2f7f79]/30" name="is_available" value="1" {{ old('is_available', $product?->is_available ?? true) ? 'checked' : '' }}>
            متاح للعرض
        </label>
        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#dce4d8] bg-[#fbf9f4] p-4 text-sm font-black text-[#12221d]">
            <input type="checkbox" class="h-4 w-4 rounded border-[#cdd6ca] text-[#2f7f79] focus:ring-[#2f7f79]/30" name="is_featured" value="1" {{ old('is_featured', $product?->is_featured ?? false) ? 'checked' : '' }}>
            صنف مميز
        </label>
    </div>

    <div class="flex flex-col gap-2 sm:flex-row">
        <button class="inline-flex flex-1 items-center justify-center rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">حفظ الصنف</button>
        <a href="{{ route('products.index', isset($page) ? ['page' => $page] : []) }}" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-5 py-3 text-sm font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">رجوع</a>
    </div>
</form>
