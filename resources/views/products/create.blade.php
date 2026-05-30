@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">صنف جديد</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">ضيف حاجة جديدة للمنيو</h1>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">اكتب الاسم والسعر واختار القسم. الصورة والوصف هيفرقوا جداً في شكل الصنف عند العميل.</p>
    </section>

    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        @include('products.partials.form', ['action' => route('products.store'), 'method' => 'POST', 'product' => null])
    </section>
</div>
@endsection
