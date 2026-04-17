@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card p-6">
    <h1 class="zz-title">تعديل المنتج</h1>
    @include('products.partials.form', ['action' => route('products.update', $product), 'method' => 'PUT', 'product' => $product])
</div>
@endsection
