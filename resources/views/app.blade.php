<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    {{-- Server-side meta description for crawlers --}}
    @if(!empty($og['description']))
        <meta name="description" content="{{ $og['description'] }}">
    @endif

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $og['url'] ?? request()->url() }}">

    {{-- Open Graph Meta Tags (server-side for crawler support) --}}
    <meta property="og:site_name" content="{{ $og['site_name'] ?? config('app.name', 'Sollu POS') }}">
    <meta property="og:title" content="{{ $og['title'] ?? config('app.name', 'Sollu POS') }}">
    @if(!empty($og['description']))
        <meta property="og:description" content="{{ $og['description'] }}">
    @endif
    @if(!empty($og['image']))
        <meta property="og:image" content="{{ $og['image'] }}">
    @endif
    <meta property="og:url" content="{{ $og['url'] ?? request()->url() }}">
    <meta property="og:type" content="{{ $og['type'] ?? 'website' }}">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="{{ !empty($og['image']) ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $og['title'] ?? config('app.name', 'Sollu POS') }}">
    @if(!empty($og['description']))
        <meta name="twitter:description" content="{{ $og['description'] }}">
    @endif
    @if(!empty($og['image']))
        <meta name="twitter:image" content="{{ $og['image'] }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
