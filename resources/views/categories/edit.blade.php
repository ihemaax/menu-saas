@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">تعديل قسم</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">{{ $category->name_ar }}</h1>
        <p class="mt-2 text-sm font-semibold leading-7 text-[#68766d]">غيّر الاسم أو الترتيب أو حالة الظهور من غير ما تلعب في باقي المنيو.</p>
    </section>

    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        @include('categories.partials.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
    </section>
</div>
@endsection
