@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl zz-card">
    <h1 class="zz-title">تعديل بيانات القسم</h1>
    <p class="zz-subtitle mt-1">حدث الاسم أو الترتيب من غير ما تغيّر باقي المنيو.</p>
    @include('categories.partials.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
</div>
@endsection
