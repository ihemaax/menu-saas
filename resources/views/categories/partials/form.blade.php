<form method="POST" action="{{ $action }}" class="mt-5 space-y-4">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div><label class="zz-label">الاسم العربي</label><input class="zz-input" name="name_ar" value="{{ old('name_ar', $category?->name_ar) }}" required></div>
    <div><label class="zz-label">الاسم الإنجليزي</label><input class="zz-input" name="name_en" value="{{ old('name_en', $category?->name_en) }}"></div>
    <div><label class="zz-label">الترتيب</label><input type="number" min="0" class="zz-input" name="sort_order" value="{{ old('sort_order', $category?->sort_order) }}"></div>
    <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}> <span>القسم نشط</span></label>
    <button class="zz-btn-primary">حفظ</button>
</form>
