@extends('layouts.app')

@section('content')
<div class="zz-card p-6">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="zz-title">الأقسام</h1>
        <a href="{{ route('categories.create') }}" class="zz-btn-primary">إضافة قسم</a>
    </div>
    @if($categories->isEmpty())
        <div class="zz-empty">لا توجد أقسام بعد.</div>
    @else
        <div class="space-y-3">
            @foreach($categories as $category)
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 p-4">
                    <div>
                        <p class="font-bold">{{ $category->name_ar }}</p>
                        <p class="text-sm text-slate-500">{{ $category->name_en ?: '—' }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="zz-badge">الترتيب: {{ $category->sort_order }}</span>
                        <span class="zz-badge {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $category->is_active ? 'نشط' : 'مخفي' }}</span>
                        <a class="zz-btn-secondary" href="{{ route('categories.edit', $category) }}">تعديل</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}">@csrf @method('DELETE')<button class="zz-btn-secondary">حذف</button></form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
