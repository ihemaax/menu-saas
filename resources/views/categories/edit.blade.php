@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card p-6">
    <h1 class="zz-title">تعديل القسم</h1>
    @include('categories.partials.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
</div>
@endsection
