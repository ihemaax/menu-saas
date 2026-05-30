<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div>
        <label class="mb-2 block text-sm font-black text-[#12221d]">اسم القسم بالعربي</label>
        <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="name_ar" value="{{ old('name_ar', $category?->name_ar) }}" placeholder="مثال: مشويات" required>
    </div>

    <div>
        <label class="mb-2 block text-sm font-black text-[#12221d]">الاسم بالإنجليزي</label>
        <input class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="name_en" value="{{ old('name_en', $category?->name_en) }}" placeholder="Grills">
    </div>

    <div>
        <label class="mb-2 block text-sm font-black text-[#12221d]">ترتيب الظهور</label>
        <input type="number" min="0" class="w-full rounded-2xl border border-[#d9dfd2] bg-[#fbf9f4] px-4 py-3 text-sm font-bold text-[#12221d] outline-none transition placeholder:text-[#9ba49a] focus:border-[#2f7f79] focus:bg-white focus:ring-4 focus:ring-[#2f7f79]/10" name="sort_order" value="{{ old('sort_order', $category?->sort_order) }}" placeholder="0">
    </div>

    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#dce4d8] bg-[#fbf9f4] p-4 text-sm font-black text-[#12221d]">
        <input type="checkbox" class="h-4 w-4 rounded border-[#cdd6ca] text-[#2f7f79] focus:ring-[#2f7f79]/30" name="is_active" value="1" {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}>
        القسم يظهر في المنيو
    </label>

    <div class="flex flex-col gap-2 sm:flex-row">
        <button class="inline-flex flex-1 items-center justify-center rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">حفظ القسم</button>
        <a href="{{ route('categories.index') }}" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-5 py-3 text-sm font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">رجوع</a>
    </div>
</form>
