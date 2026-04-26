@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card">
    <h1 class="zz-title">تعديل الصنف</h1>
    <p class="zz-subtitle mt-1">عدّل السعر أو الوصف أو الحالة بنفس سهولة الإضافة.</p>
    @include('products.partials.form', ['action' => route('products.update', $product), 'method' => 'PUT', 'product' => $product, 'page' => $page])
</div>
@endsection
