<form method="POST" action="{{ $action }}" class="mt-6 space-y-6">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <section class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="zz-label">الاسم العربي</label>
            <input class="zz-input" name="name_ar" value="{{ old('name_ar', $category?->name_ar) }}" required>
        </div>

        <div>
            <label class="zz-label">الاسم الإنجليزي</label>
            <input class="zz-input" name="name_en" value="{{ old('name_en', $category?->name_en) }}">
        </div>

        <div>
            <label class="zz-label">الترتيب</label>
            <input type="number" min="0" class="zz-input" name="sort_order" value="{{ old('sort_order', $category?->sort_order) }}">
        </div>

        <div class="flex items-end">
            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input class="zz-checkbox" type="checkbox" name="is_active" value="1" {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}>
                القسم نشط
            </label>
        </div>
    </section>

    <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
        <a href="{{ route('categories.index') }}" class="zz-btn-secondary">إلغاء</a>
        <button class="zz-btn-primary">حفظ القسم</button>
    </div>
</form>
