@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <h1 class="zz-title">تعديل المنتج</h1>
        <p class="zz-subtitle mt-1">حدّث البيانات والصورة وحالة الإتاحة بسهولة.</p>
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('products.partials.form', ['action' => route('products.update', $product), 'method' => 'PUT', 'product' => $product])
    </section>
</div>
@endsection
