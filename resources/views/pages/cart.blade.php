@extends('template')
@section('main')
    <main class="main">
        <x-breadcrumbs :items="$bread"/>
        <section class="section section--dark cart">
            <div class="container cart__container">
                <h1 class="page-title">{{ $h1 }}</h1>
                <div class="overflow-x">
                    <table class="cart__table">
                        <thead>
                        <tr>
                            <th>Размер</th>
                            <th>Ст</th>
                            <th>Гост</th>
                            <th>Убрать</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(Cart::getCart() as $cartItem)
                            <tr data-id="{{ $cartItem['model']->id }}">
                                <td class="text-left">
                                    <a href="{{ $cartItem['model']->url }}" title="{{ $cartItem['model']->name }}">{{ $cartItem['model']->name }}</a>
                                </td>
                                <td>{{ $cartItem['model']->steel }}</td>
                                <td>{{ $cartItem['model']->gost }}</td>
                                <td class="remove">
                                    <span onClick="removeFromCart(this)"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <form class="form cart__form" action="{{ route('ajax.order') }}" onsubmit="sendOrder(this, event)">
                    <div class="page__block-title">Информация о покупателе</div>
                    <div class="cart__user">
                        <div class="form__column">
                            <input type="text" name="name" placeholder="Ваше имя" aria-label="Ваше имя" required>
                            <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" aria-label="Ваш телефон"
                                   required>
                            <input type="text" name="email" placeholder="E-mail" aria-label="E-mail">
                        </div>
                        <div class="form__column">
                            <textarea name="text" placeholder="Комментарий к заказу"
                                      aria-label="Комментарий к заказу"></textarea>
                        </div>
                        <div class="form__column">
                            <div class="cart__options">
                                <div class="cart__option">
                                    <div class="checkbox">
                                        <input type="hidden" name="cut" value="0"/>
                                        <input id="cb1" type="checkbox" name="cut" value="1">
                                        <label for="cb1">Резка</label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="hidden" name="delivery" value="0"/>
                                        <input id="cb2" type="checkbox" name="delivery" value="1">
                                        <label for="cb2">Доставка</label>
                                    </div>
                                </div>
                                <div class="cart__option cart__select">
                                    <label class="label">Выбрать склад
                                        <select class="js-select" name="stock" required>
                                            <option value="Полевской">Полевской</option>
                                            <option value="Самовывоз">Самовывоз</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form__column">
                            <button class="btn">Отправить заказ</button>
                            <div class="form__policy">Нажимая кнопку &laquo;Отправить заказ&raquo;, вы&nbsp;соглашаетесь
                                с&nbsp;
                                <a class="policy" href="policy.html" target="_blank">политикой конфиденциальности</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
