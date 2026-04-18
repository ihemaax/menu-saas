@extends('layouts.app')

@section('content')
<div class="zz-page max-w-4xl">
    <section class="zz-page-header">
        <h1 class="zz-title">الحساب الشخصي</h1>
        <p class="zz-subtitle mt-1">إدارة بيانات الحساب، كلمة المرور، وخيارات الأمان.</p>
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('profile.partials.update-profile-information-form')
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('profile.partials.update-password-form')
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('profile.partials.delete-user-form')
    </section>
</div>
@endsection
