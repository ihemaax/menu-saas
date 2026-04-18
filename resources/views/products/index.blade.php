@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="zz-title">إدارة المنتجات</h1>
                <p class="zz-subtitle mt-1">عرض كل الأصناف مع تحكم سريع في الحالة والتصنيف.</p>
            </div>
            <a href="{{ route('products.create') }}" class="zz-btn-primary w-full sm:w-auto">إضافة منتج</a>
        </div>
    </section>

    <section class="zz-card p-4 md:p-6">
        @if($products->isEmpty())
            <div class="zz-empty">لا توجد منتجات حتى الآن. ابدأ بإضافة أول عنصر للقائمة.</div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($products as $product)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/700x420?text=No+Image' }}" class="h-44 w-full object-cover" alt="{{ $product->name }}">
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-bold text-slate-900">{{ $product->name }}</h3>
                                <span class="zz-chip">{{ number_format($product->price, 2) }} ج.م</span>
                            </div>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ $product->category->name_ar }}</p>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $product->description ?: 'بدون وصف.' }}</p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="zz-chip {{ $product->is_available ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-500' }}">{{ $product->is_available ? 'متاح' : 'غير متاح' }}</span>
                                @if($product->is_featured)
                                    <span class="zz-chip border-amber-200 bg-amber-100 text-amber-700">مميز</span>
                                @endif
                            </div>

                            <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                <a class="zz-btn-secondary w-full" href="{{ route('products.edit', $product) }}">تعديل</a>
                                <form class="w-full" method="POST" action="{{ route('products.destroy', $product) }}">@csrf @method('DELETE')<button class="zz-btn-danger w-full">حذف</button></form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-5">{{ $products->links() }}</div>
        @endif
    </section>
</div>
@endsection
