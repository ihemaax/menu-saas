@extends('layouts.app')

@section('content')
<div class="zz-card">
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="zz-title">المنتجات</h1>
            <p class="zz-subtitle mt-1">كل الأصناف قدامك، عدّل المحتوى والسعر والتوفر بسهولة.</p>
        </div>
        <a href="{{ route('products.create') }}" class="zz-btn-primary">إضافة صنف</a>
    </div>

    @if($products->isEmpty())
        <div class="zz-empty">المنيو لسه فاضية. ابدأ بأول صنف وخلّي صفحة العرض تتحرك.</div>
    @else
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $product)
                <article class="rounded-3xl border border-[#e1d8c8] bg-white p-4 shadow-[0_8px_20px_rgba(36,42,33,0.06)]">
                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/700x420?text=No+Image' }}" class="h-40 w-full rounded-2xl object-cover" alt="{{ $product->name }}">
                    <div class="mt-3">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-[#263226]">{{ $product->name }}</h3>
                            <span class="zz-chip">{{ number_format($product->price, 2) }}</span>
                        </div>
                        <p class="mt-1 text-sm text-[#6c685d]">{{ $product->category->name_ar }}</p>
                        <p class="mt-2 line-clamp-2 text-sm text-[#4f5a4f]">{{ $product->description ?: 'بدون وصف حالياً.' }}</p>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="zz-badge {{ $product->is_available ? 'zz-badge-active' : 'zz-badge-muted' }}">{{ $product->is_available ? 'متاح للطلب' : 'مخفي' }}</span>
                        @if($product->is_featured)<span class="zz-badge zz-badge-muted">مميز</span>@endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a class="zz-btn-secondary w-full" href="{{ route('products.edit', ['product' => $product, 'page' => $products->currentPage()]) }}">تعديل</a>
                        <form class="w-full" method="POST" action="{{ route('products.destroy', $product) }}">@csrf @method('DELETE')<input type="hidden" name="page" value="{{ $products->currentPage() }}"><button class="zz-btn-danger w-full">حذف</button></form>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-5">{{ $products->links() }}</div>
    @endif
</div>
@endsection
