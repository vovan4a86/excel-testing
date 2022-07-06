<head>
    <meta charset="utf-8">
    {!! SEOMeta::generate() !!}
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/static/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/static/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/static/images/favicon/safari-pinned-tab.svg" color="#ffffff">
    <link rel="icon" href="/static/images/favicon/favicon.svg">
    <link rel="shortcut icon" href="/static/images/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="name">
    <meta name="application-name" content="name">
    <meta name="cmsmagazine" content="18db2cabdd3bf9ea4cbca88401295164">
    <meta name="author" content="regionmetprom.ru">
    <meta name="msapplication-TileColor" content="#ab0000">
    <meta name="msapplication-config" content="/static/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    {!! OpenGraph::generate() !!}
    <link href="/static/fonts/RegionTrebuchetMS.woff2" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="/static/fonts/RegionTrebuchetMS-Bold.woff2" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="/static/fonts/RegionCenturyGothic.woff2" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="/static/fonts/RegionCenturyGothic-Bold.woff2" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="/static/fonts/RegionSegoeUI.woff2" rel="preload" as="font" type="font/woff2" crossorigin>
    <!---->
    <link rel="stylesheet" type="text/css" href="{{ mix('static/css/all.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($canonical))
        <link rel="canonical" href="{{ $canonical }}"/>
    @endif
</head>
