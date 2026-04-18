@extends('layouts.app')

@section('content')
<div class="zz-page">
    <section class="zz-page-header">
        <h1 class="zz-title">تعديل القسم</h1>
        <p class="zz-subtitle mt-1">تحديث اسم القسم، ترتيبه، أو حالة ظهوره.</p>
    </section>

    <section class="zz-card p-5 md:p-6">
        @include('categories.partials.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
    </section>
</div>
@endsection
