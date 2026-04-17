@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ __('Settings') }}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Restaurant Information') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Restaurant Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tenant->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">{{ __('Menu URL Slug') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ url('/') }}/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $tenant->slug) }}" pattern="[a-z0-9-]+" required>
                        </div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ __('Only lowercase letters, numbers, and hyphens allowed') }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $tenant->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">{{ __('Restaurant Logo') }}</label>
                        @if($tenant->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ __('Leave empty to keep current logo. Recommended size: 300x300px') }}</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_open" name="is_open" value="1" {{ old('is_open', $tenant->is_open) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_open">
                            {{ __('Restaurant is currently open') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> {{ __('Save Settings') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($tenant->slug)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('QR Code') }}</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="{{ route('settings.qr') }}" alt="QR Code" class="img-fluid">
                </div>
                <p class="text-muted small">{{ __('Scan to view menu') }}</p>
                <a href="{{ route('settings.qr') }}" download="menu-qr.png" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-download"></i> {{ __('Download QR') }}
                </a>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Menu Preview') }}</h5>
            </div>
            <div class="card-body">
                @if($tenant->slug)
                    <a href="{{ route('menu.show', $tenant->slug) }}" target="_blank" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-eye"></i> {{ __('View Public Menu') }}
                    </a>
                @else
                    <p class="text-muted small mb-0">{{ __('Save settings to generate menu URL') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection