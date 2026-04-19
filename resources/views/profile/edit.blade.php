@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="zz-card">
        <h1 class="zz-title">الحساب والبيانات</h1>
        <p class="zz-subtitle mt-1">حدّث بيانات الدخول وكلمة السر من هنا.</p>
    </div>

    <div class="zz-card">
        <div class="max-w-2xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="zz-card">
        <div class="max-w-2xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="zz-card">
        <div class="max-w-2xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
