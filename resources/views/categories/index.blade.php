@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Categories') }}</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> {{ __('Add Category') }}
        </a>
    </div>
</div>

@if($categories->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Name (Arabic)') }}</th>
                                <th>{{ __('Name (English)') }}</th>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Products') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name_ar }}</td>
                                <td>{{ $category->name_en }}</td>
                                <td>{{ $category->order }}</td>
                                <td>{{ $category->products->count() }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> {{ __('Edit') }}
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure?') }}')">
                                            <i class="bi bi-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-tags display-4 text-muted mb-3"></i>
                <h4>{{ __('No categories yet') }}</h4>
                <p class="text-muted">{{ __('Start by adding your first category') }}</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> {{ __('Add First Category') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection