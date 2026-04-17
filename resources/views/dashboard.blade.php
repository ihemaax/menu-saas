@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">{{ __('Dashboard') }}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-tags"></i> {{ __('Categories') }}
                </h5>
                <h2 class="card-text">{{ $categoriesCount }}</h2>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">{{ __('Manage Categories') }}</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-box-seam"></i> {{ __('Products') }}
                </h5>
                <h2 class="card-text">{{ $productsCount }}</h2>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('Manage Products') }}</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-gear"></i> {{ __('Settings') }}
                </h5>
                <p class="card-text">{{ __('Configure your restaurant settings') }}</p>
                <a href="{{ route('settings.index') }}" class="btn btn-primary">{{ __('Manage Settings') }}</a>
            </div>
        </div>
    </div>
</div>

@if($tenant->slug)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-qr-code"></i> {{ __('Public Menu') }}
                </h5>
                <p class="card-text">{{ __('Your menu is available at:') }}</p>
                <a href="{{ route('menu.show', $tenant->slug) }}" target="_blank" class="btn btn-outline-primary me-2">
                    <i class="bi bi-eye"></i> {{ __('View Menu') }}
                </a>
                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-qr-code"></i> {{ __('View QR Code') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
