<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Za3tr-Zatona' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo']">
<div class="min-h-screen px-4 py-8 md:px-6">
    <div class="mx-auto max-w-md">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="text-3xl font-extrabold text-teal-800">Za3tr-Zatona</a>
            <p class="mt-2 text-sm text-slate-500">نظام SaaS احترافي لإدارة منيو المطاعم</p>
        </div>
        <div class="zz-card p-6">
            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>
