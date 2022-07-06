<div class="breadcrumbs">
    <div class="container breadcrumbs__container">
        <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
            @foreach($items as $item)
            <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a class="breadcrumbs__link" href="{!! $loop->last ? 'javascript:void(0)': array_get($item, 'url') !!}" itemprop="item">
                    <span itemprop="name">{{ array_get($item, 'name') }}</span>
                    <meta itemprop="position" content="{{ $loop->index + 1 }}">
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>