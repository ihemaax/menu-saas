@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="zz-title">إدارة الأقسام</h1>
                <p class="zz-subtitle mt-1">تنظيم أقسام المنيو وترتيبها بشكل واضح للعميل.</p>
            </div>
            <a href="{{ route('categories.create') }}" class="zz-btn-primary w-full sm:w-auto">إضافة قسم</a>
        </div>
    </section>

    <section class="zz-card p-4 md:p-6">
        @if($categories->isEmpty())
            <div class="zz-empty">لا توجد أقسام بعد. أضف أول قسم لتقسيم المنتجات.</div>
        @else
            <div class="grid gap-3 md:grid-cols-2">
                @foreach($categories as $category)
                    <article class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="font-bold text-slate-900">{{ $category->name_ar }}</h2>
                                <p class="mt-1 text-sm text-slate-500">{{ $category->name_en ?: 'بدون اسم إنجليزي' }}</p>
                            </div>
                            <span class="zz-badge {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $category->is_active ? 'نشط' : 'مخفي' }}</span>
                        </div>
                        <p class="mt-3 text-xs font-semibold text-slate-500">الترتيب: {{ $category->sort_order }}</p>
                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                            <a class="zz-btn-secondary w-full" href="{{ route('categories.edit', $category) }}">تعديل</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="w-full">@csrf @method('DELETE')<button class="zz-btn-danger w-full">حذف</button></form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
