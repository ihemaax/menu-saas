@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-black text-[#2f7f79]">أقسام المنيو</p>
                <h1 class="mt-1 text-3xl font-black text-[#12221d]">رتّب المنيو على مزاجك</h1>
                <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">
                    خلي العميل يوصل للأكل أو الخدمة بسرعة. اعمل أقسام واضحة زي مشروبات، أطباق رئيسية، عروض، أو خدمات.
                </p>
            </div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white shadow-[0_16px_34px_rgba(213,84,65,0.24)] transition hover:bg-[#bd4838]">
                <x-icon name="category" class="h-5 w-5" />
                قسم جديد
            </a>
        </div>
    </section>

    @if($categories->isEmpty())
        <section class="rounded-[28px] border border-dashed border-[#d55441]/45 bg-[#fff0ed] p-8 text-center">
            <h2 class="text-2xl font-black text-[#12221d]">لسه مفيش أقسام</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm font-bold leading-7 text-[#8b3b2e]">ابدأ بقسم بسيط زي مشروبات أو وجبات رئيسية، وبعدها ضيف الأصناف جواه.</p>
            <a href="{{ route('categories.create') }}" class="mt-5 inline-flex items-center justify-center rounded-2xl bg-[#d55441] px-5 py-3 text-sm font-black text-white transition hover:bg-[#bd4838]">ضيف أول قسم</a>
        </section>
    @else
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($categories as $category)
                <article class="rounded-[26px] border border-[#dce4d8] bg-white p-5 shadow-[0_14px_34px_rgba(33,43,37,0.06)]">
                    <div class="mb-5 flex items-start justify-between gap-4">
                        <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#eef8f6] text-[#2f7f79]">
                            <x-icon name="category" class="h-6 w-6" />
                        </span>
                        <span class="rounded-full px-3 py-1 text-[11px] font-black {{ $category->is_active ? 'bg-[#edf9f5] text-[#23625c]' : 'bg-[#f4f0e7] text-[#68766d]' }}">
                            {{ $category->is_active ? 'ظاهر للعميل' : 'مخفي حالياً' }}
                        </span>
                    </div>

                    <h2 class="text-xl font-black text-[#12221d]">{{ $category->name_ar }}</h2>
                    <p class="mt-1 text-sm font-bold text-[#68766d]">{{ $category->name_en ?: 'مفيش اسم إنجليزي' }}</p>

                    <div class="mt-5 flex items-center justify-between rounded-2xl bg-[#fbf9f4] px-4 py-3">
                        <span class="text-xs font-black text-[#68766d]">الترتيب</span>
                        <strong class="text-lg font-black text-[#12221d]">{{ $category->sort_order }}</strong>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <a class="inline-flex items-center justify-center rounded-2xl border border-[#2f7f79] bg-white px-4 py-3 text-sm font-black text-[#2f7f79] transition hover:bg-[#eef8f6]" href="{{ route('categories.edit', $category) }}">تعديل</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')
                            <button class="w-full rounded-2xl bg-[#fff0ed] px-4 py-3 text-sm font-black text-[#b84d3a] transition hover:bg-[#fbe0db]">حذف</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
</div>
@endsection
