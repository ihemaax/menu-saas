@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <h1 class="zz-title">إضافة قسم جديد</h1>
        <p class="zz-subtitle mt-1">نظّم قائمة الطعام عبر تقسيمات واضحة وسهلة التصفح.</p>
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('categories.partials.form', ['action' => route('categories.store'), 'method' => 'POST', 'category' => null])
    </section>
</div>
@endsection
