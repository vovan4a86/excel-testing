<div class="header__order header-order">
    @if(Cart::getCount())
        <div class="header-order__icon"></div>
        <div class="header-order__content">
            <a href="{{ route('cart') }}" title="Лист заказа">Лист заказа
                <span>({{ Cart::getCount() }})</span>
            </a>
        </div>
    @endif
</div>