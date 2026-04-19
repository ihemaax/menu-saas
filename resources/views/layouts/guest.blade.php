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
<div class="zz-auth-wrap">
    <section class="zz-auth-visual">
        <div class="relative z-10">
            <p class="text-sm opacity-80">Za3tr-Zatona</p>
            <h1 class="mt-3 text-4xl font-extrabold leading-tight">منيو شكله احترافي<br>من أول زيارة.</h1>
            <p class="mt-4 max-w-md text-white/85">أضف الأصناف، رتّب الأقسام، وشارك رابط واحد يعرض المنيو بشكل يليق بمكانك.</p>
            <div class="mt-8 grid max-w-sm grid-cols-2 gap-3 text-sm">
                <div class="rounded-2xl bg-white/15 p-3">إعدادات سريعة</div>
                <div class="rounded-2xl bg-white/15 p-3">تجربة موبايل ممتازة</div>
                <div class="rounded-2xl bg-white/15 p-3">لينك + QR</div>
                <div class="rounded-2xl bg-white/15 p-3">اختيار ثيم مباشر</div>
            </div>
        </div>
        <div class="absolute -bottom-16 -left-8 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
    </section>
    <section class="zz-auth-panel">
        <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">{{ $slot }}</div>
    </section>
</div>
</body>
</html>
