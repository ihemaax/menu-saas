<form method="POST" action="{{ $action }}" class="mt-5 space-y-4">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div>
        <label class="zz-label">اسم القسم بالعربي</label>
        <input class="zz-input" name="name_ar" value="{{ old('name_ar', $category?->name_ar) }}" placeholder="مثال: مشويات" required>
    </div>

    <div>
        <label class="zz-label">الاسم بالإنجليزي (اختياري)</label>
        <input class="zz-input" name="name_en" value="{{ old('name_en', $category?->name_en) }}" placeholder="Grills">
    </div>

    <div>
        <label class="zz-label">الترتيب</label>
        <input type="number" min="0" class="zz-input" name="sort_order" value="{{ old('sort_order', $category?->sort_order) }}" placeholder="0">
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold text-[#2f3a2f]"><input type="checkbox" class="zz-checkbox" name="is_active" value="1" {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}> القسم يظهر في المنيو</label>

    <div class="flex gap-2">
        <button class="zz-btn-primary">حفظ القسم</button>
        <a href="{{ route('categories.index') }}" class="zz-btn-secondary">رجوع</a>
    </div>
</form>
