@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        <p class="text-xs font-black text-[#2f7f79]">الحساب</p>
        <h1 class="mt-1 text-3xl font-black text-[#12221d]">بيانات الدخول والأمان</h1>
        <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-[#68766d]">من هنا تغيّر اسمك، الإيميل، والباسورد. خليك حذر مع حذف الحساب لأنه خطوة نهائية.</p>
    </section>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="rounded-[30px] border border-[#dce4d8] bg-white p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
            @include('profile.partials.update-password-form')
        </section>
    </div>

    <section class="rounded-[30px] border border-[#efc5bd] bg-[#fff0ed] p-5 shadow-[0_16px_38px_rgba(33,43,37,0.06)] sm:p-6">
        @include('profile.partials.delete-user-form')
    </section>
</div>
@endsection
