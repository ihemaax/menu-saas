@extends('layouts.app')

@section('content')
<div class="zz-card p-6">
    <div class="mb-4 flex items-center justify-between"><h1 class="zz-title">المنتجات</h1><a href="{{ route('products.create') }}" class="zz-btn-primary">أضف منتج</a></div>

    @if($products->isEmpty())
        <div class="zz-empty">مافيش منتجات لحد دلوقتي.</div>
    @else
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $product)
                <article class="rounded-2xl border border-slate-200 bg-white p-4">
                    <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/700x420?text=No+Image' }}" class="h-40 w-full rounded-xl object-cover" alt="{{ $product->name }}">
                    <div class="mt-3">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold">{{ $product->name }}</h3>
                            <span class="zz-chip">{{ number_format($product->price, 2) }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">{{ $product->category->name_ar }}</p>
                        <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $product->description }}</p>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="zz-chip {{ $product->is_available ? 'bg-emerald-100 text-emerald-700' : '' }}">{{ $product->is_available ? 'متاح' : 'مخفي' }}</span>
                        @if($product->is_featured)<span class="zz-chip bg-amber-100 text-amber-700">مميز</span>@endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a class="zz-btn-secondary w-full" href="{{ route('products.edit', $product) }}">تعديل</a>
                        <form class="w-full" method="POST" action="{{ route('products.destroy', $product) }}">@csrf @method('DELETE')<button class="zz-btn-secondary w-full">حذف</button></form>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-5">{{ $products->links() }}</div>
    @endif
</div>
@endsection
