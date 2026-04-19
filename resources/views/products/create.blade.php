@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card">
    <h1 class="zz-title">إضافة صنف جديد</h1>
    <p class="zz-subtitle mt-1">املأ البيانات الأساسية وخلي الصنف جاهز للعرض فورًا.</p>
    @include('products.partials.form', ['action' => route('products.store'), 'method' => 'POST', 'product' => null])
</div>
@endsection
