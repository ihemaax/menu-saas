@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="zz-card p-6">
        <h1 class="zz-title">الثيمات</h1>
        <p class="zz-subtitle mt-1">بدّل شكل المنيو في ثانية من غير ما تلمس الأصناف.</p>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        @foreach($themes as $key => $theme)
            <article class="zz-card p-5">
                <div class="mb-3 flex gap-2">
                    @foreach($theme['preview_colors'] as $color)
                        <span class="h-6 w-6 rounded-full border border-slate-200" style="background: {{ $color }}"></span>
                    @endforeach
                </div>
                <h2 class="font-bold">{{ $theme['label'] }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $theme['description'] }}</p>

                <div class="mt-4 flex items-center justify-between">
                    @if($restaurant->menuSetting->active_theme === $key)
                        <span class="zz-chip bg-emerald-100 text-emerald-700">الثيم الحالي</span>
                    @else
                        <span class="zz-chip">مش متفعل</span>
                    @endif

                    <form method="POST" action="{{ route('themes.update') }}">@csrf @method('PUT')
                        <input type="hidden" name="theme" value="{{ $key }}">
                        <button class="zz-btn-primary">تفعيل</button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection
