@php
    $seoTitle = $seoTitle ?? 'Osirix | منيو ديجيتال للمطاعم والصالونات';
    $seoDescription = $seoDescription ?? 'Osirix منصة بسيطة لعمل منيو ديجيتال وQR للمطاعم والكافيهات والصالونات.';
    $seoCanonical = $seoCanonical ?? url()->current();
    $seoImage = $seoImage ?? asset('osirix-logo.svg');
    $seoType = $seoType ?? 'website';
    $seoLocale = $seoLocale ?? 'ar_EG';
@endphp

<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ ! empty($seoNoIndex) ? 'noindex, nofollow' : 'index, follow' }}">
<link rel="canonical" href="{{ $seoCanonical }}">

<meta property="og:locale" content="{{ $seoLocale }}">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
