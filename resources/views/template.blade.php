<!DOCTYPE html>
<html lang="ru-RU">
@include('blocks.head')
<body class="no-scroll">
<div class="preloader">
    <div class="preloader__loader">Загрузка...</div>
</div>
<div class="scrolltop" aria-label="В начало страницы" tabindex="1"></div>
<x-header />
@yield('main')
<x-footer />
@include('blocks.popups')
<div class="visually-hidden" itemscope itemtype="https://schema.org/Organization" aria-hidden="true" tabindex="-1">
    <div itemprop="name">ООО "Регионметпром"</div>
    <a itemprop="url" href="https://www.example.com"></a>
    <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
        <span itemprop="addressCountry">Россия</span>,
        <span itemprop="addressRegion">Свердловская область</span>,
        <span itemprop="postalCode">620144</span>,
        <span itemprop="addressLocality">Екатеринбург</span>,
        <span itemprop="streetAddress">ул. Циолковского, д.29 оф. 4Г</span>
        <div itemprop="email">met@midural.ru</div>
        <div itemprop="telephone">+7 (343) 300-34-35</div>
    </div>
    <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
        <span itemprop="addressCountry">Россия</span>,
        <span itemprop="addressRegion">Челябинская область</span>,
        <span itemprop="postalCode">454053</span>,
        <span itemprop="addressLocality">Челябинск</span>,
        <span itemprop="streetAddress">ул. Троицкий тракт, д. 54 оф. 208</span>
        <div itemprop="email">rmp@bk.ru</div>
        <div itemprop="telephone">+7 (351) 211-08-17</div>
    </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
<script type="text/javascript" defer="" src="{{ mix('static/js/all.js') }}"></script>

</div>
</body>
</html>
