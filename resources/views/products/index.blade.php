@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-black text-[#2f7f79]">الأصناف</p>
                <h1 class="mt-1 text-3xl font-black text-[#12221d]">كل اللي بيتعرض للعميل</h1>
                <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">عدّل السعر والصورة والتوفر بسرعة. كل كارت هنا هو صنف ظاهر أو جاهز يظهر في المنيو.</p>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white shadow-[0_16px_34px_rgba(213,84,65,0.24)] transition hover:bg-[#bd4838]">
                <x-icon name="product" class="h-5 w-5" />
                صنف جديد
            </a>
        </div>
    </section>

    @if($products->isEmpty())
        <section class="rounded-[28px] border border-dashed border-[#d55441]/45 bg-[#fff0ed] p-8 text-center">
            <h2 class="text-2xl font-black text-[#12221d]">المنيو لسه فاضية</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm font-bold leading-7 text-[#8b3b2e]">ضيف أول صنف باسم وسعر وصورة، وبعدها الصفحة هتبدأ تبان حلوة للعميل.</p>
            <a href="{{ route('products.create') }}" class="mt-5 inline-flex items-center justify-center rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">ضيف أول صنف</a>
        </section>
    @else
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $product)
                <article class="overflow-hidden rounded-[28px] border border-[#dce4d8] bg-white shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
                    <div class="relative">
                        <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : 'https://placehold.co/700x420/fbf6ec/12221d?text=Osirix' }}" class="h-48 w-full object-cover" alt="{{ $product->name }}">
                        <div class="absolute right-3 top-3 flex flex-wrap gap-2">
                            <span class="rounded-full px-3 py-1 text-[11px] font-black {{ $product->is_available ? 'bg-[#edf9f5] text-[#23625c]' : 'bg-[#f4f0e7] text-[#68766d]' }}">{{ $product->is_available ? 'متاح' : 'مخفي' }}</span>
                            @if($product->is_featured)
                                <span class="rounded-full bg-[#fff3df] px-3 py-1 text-[11px] font-black text-[#94611c]">مميز</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate text-xl font-black text-[#12221d]">{{ $product->name }}</h3>
                                <p class="mt-1 text-sm font-bold text-[#68766d]">{{ $product->category->name_ar }}</p>
                            </div>
                            <strong class="shrink-0 rounded-2xl bg-[#eef8f6] px-3 py-2 text-sm font-black text-[#2f7f79]">{{ number_format($product->price, 2) }}</strong>
                        </div>

                        <p class="mt-3 line-clamp-2 min-h-[3.5rem] text-sm font-semibold leading-7 text-[#68766d]">{{ $product->description ?: 'مفيش وصف مكتوب للصنف ده حالياً.' }}</p>

                        <form method="POST" action="{{ route('products.image.update', $product) }}" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="page" value="{{ $products->currentPage() }}">
                            <input id="product-image-{{ $product->id }}" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="sr-only" onchange="this.form.submit()">
                            <label for="product-image-{{ $product->id }}" class="inline-flex w-full cursor-pointer items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-4 py-3 text-sm font-black text-[#2f7f79] transition hover:bg-[#eef8f6]">
                                {{ $product->image_path ? 'غيّر الصورة' : 'ضيف صورة' }}
                            </label>
                        </form>

                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <a class="inline-flex items-center justify-center rounded-2xl bg-[#12221d] px-4 py-3 text-sm font-black text-white transition hover:bg-[#1f3a33]" href="{{ route('products.edit', ['product' => $product, 'page' => $products->currentPage()]) }}">تعديل</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="page" value="{{ $products->currentPage() }}">
                                <button class="w-full rounded-2xl bg-[#fff0ed] px-4 py-3 text-sm font-black text-[#b84d3a] transition hover:bg-[#fbe0db]">حذف</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
        <div class="rounded-[24px] border border-[#dce4d8] bg-white p-4 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">{{ $products->links() }}</div>
    @endif
</div>
@endsection
