@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">قسم جديد</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">ضيف قسم للمنيو</h1>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">اكتب اسم القسم وحدد ترتيبه. خليه واضح وقصير عشان العميل يلاقي اللي بيدور عليه بسرعة.</p>
    </section>

    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        @include('categories.partials.form', ['action' => route('categories.store'), 'method' => 'POST', 'category' => null])
    </section>
</div>
@endsection
