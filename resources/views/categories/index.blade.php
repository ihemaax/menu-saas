@extends('layouts.app')

@section('content')
<div class="zz-card space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="zz-title">أقسام المنيو</h1>
            <p class="zz-subtitle mt-1">رتّب الأقسام بالشكل اللي يسهّل على الزبون يوصل للصنف بسرعة.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="zz-btn-primary">إضافة قسم جديد</a>
    </div>

    @if($categories->isEmpty())
        <div class="zz-empty">لسه مفيش أقسام. ابدأ بقسم أساسي زي المشروبات أو الوجبات الرئيسية.</div>
    @else
        <div class="space-y-3">
            @foreach($categories as $category)
                <div class="rounded-2xl border border-[#e3dacb] bg-[#fffdfa] p-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-base font-bold text-[#263226]">{{ $category->name_ar }}</p>
                            <p class="text-sm text-[#6c685d]">{{ $category->name_en ?: 'بدون اسم إنجليزي' }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="zz-chip">الترتيب: {{ $category->sort_order }}</span>
                            <span class="zz-badge {{ $category->is_active ? 'zz-badge-active' : 'zz-badge-muted' }}">{{ $category->is_active ? 'ظاهر في المنيو' : 'مخفي حاليًا' }}</span>
                            <a class="zz-btn-secondary" href="{{ route('categories.edit', $category) }}">تعديل</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}">@csrf @method('DELETE')<button class="zz-btn-danger">حذف</button></form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
