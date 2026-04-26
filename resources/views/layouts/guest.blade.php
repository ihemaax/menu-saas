<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Osirix' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo']">
<div class="zz-auth-wrap">
    <section class="zz-auth-visual">
        <div class="relative z-10">
            <p class="text-sm font-semibold tracking-[0.24em] text-[#ead7ad]">OSIRIX</p>
            <h1 class="mt-3 text-4xl font-extrabold leading-tight">قوة تنظيم مستوحاة من<br>عظمة الحضارة المصرية.</h1>
            <p class="mt-4 max-w-md text-[#f6efde]">Osirix بواجهة فخمة وهادية تخليك تدير مطعمك بثبات ووضوح، من أول تسجيل دخول لحد أدق تفصيلة.</p>
            <div class="mt-8 grid max-w-sm grid-cols-2 gap-3 text-sm">
                <div class="rounded-2xl border border-[#e0c788]/35 bg-[#20170f]/35 p-3">لوحة تحكم ملكية</div>
                <div class="rounded-2xl border border-[#e0c788]/35 bg-[#20170f]/35 p-3">متابعة الاشتراك</div>
                <div class="rounded-2xl border border-[#e0c788]/35 bg-[#20170f]/35 p-3">إدارة الحساب بسهولة</div>
                <div class="rounded-2xl border border-[#e0c788]/35 bg-[#20170f]/35 p-3">هوية بصرية فخمة</div>
            </div>
        </div>
        <div class="absolute -bottom-16 -left-8 h-64 w-64 rounded-full bg-[#d5af69]/30 blur-2xl"></div>
    </section>
    <section class="zz-auth-panel">
        <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">{{ $slot }}</div>
    </section>
</div>
</body>
</html>
