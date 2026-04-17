@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card p-6">
    <h1 class="zz-title">إضافة قسم جديد</h1>
    @include('categories.partials.form', ['action' => route('categories.store'), 'method' => 'POST', 'category' => null])
</div>
@endsection
