@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card p-6">
    <h1 class="zz-title">إضافة منتج</h1>
    @include('products.partials.form', ['action' => route('products.store'), 'method' => 'POST', 'product' => null])
</div>
@endsection
