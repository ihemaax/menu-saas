@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card">
    <h1 class="zz-title">إضافة قسم جديد</h1>
    <p class="zz-subtitle mt-1">ضيف القسم وحدد ترتيبه عشان شكل المنيو يفضل منظم.</p>
    @include('categories.partials.form', ['action' => route('categories.store'), 'method' => 'POST', 'category' => null])
</div>
@endsection
