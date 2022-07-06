<div class="zoom-anim-dialog mfp-hide" id="map-dialog">
    <div id="map" data-lat="56.471869" data-long="60.238957" data-hint="Регионметпром, 2А/5, территория Восточный Промышленный Район, Полевской, Россия"></div>
</div>
<div class="popup zoom-anim-dialog mfp-hide" id="callback">
    <div class="popup__content">
        <div class="page__block-formtitle text-center">Заказать звонок</div>
        <form class="form" action="{{ route('ajax.callback') }}" onsubmit="sendCallback(this, event)">
            <div class="form__column">
                <input type="text" name="name" placeholder="Ваше имя" aria-label="Ваше имя" required>
                <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" aria-label="Ваш телефон" required>
            </div>
            <div class="form__column">
                <button class="btn">Перезвоните мне</button>
                <div class="form__policy">Нажимая кнопку &laquo;Перезвоните мне&raquo;, вы&nbsp;соглашаетесь с&nbsp;
                    <a href="{{ url('policy') }}" target="_blank">политикой конфиденциальности</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="popup zoom-anim-dialog mfp-hide" id="question">
    <div class="popup__content">
        <div class="page__block-formtitle text-center">Задать вопрос</div>
        <form class="form" action="{{ route('ajax.question') }}" onsubmit="sendCallback(this, event)">
            <div class="form__column">
                <input type="text" name="name" placeholder="Ваше имя" aria-label="Ваше имя" required>
                <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" aria-label="Ваш телефон" required>
                <textarea name="text" placeholder="Вопрос" aria-label="Сообщение"></textarea>
            </div>
            <div class="form__column" style="margin-top: 20px">
                <button class="btn">Отправить</button>
                <div class="form__policy">Нажимая кнопку &laquo;Отправить&raquo;, вы&nbsp;соглашаетесь с&nbsp;
                    <a href="{{ url('policy') }}" target="_blank">политикой конфиденциальности</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="popup zoom-anim-dialog mfp-hide" id="order">
    <div class="page__block-formtitle text-center">Товар добавлен в лист заказа</div>
    <form class="form" action="#">
        <input type="hidden" name="product">
        <div class="popup__title"></div>
        <div class="popup__actions">
            <a class="page__link" href="javascript:void(0)" onClick="closePopup();">Продолжить выбор</a>
            <div class="divider">или</div>
            <a class="btn" href="{{ route('cart') }}">Оформить заказ</a>
        </div>
    </form>
</div>
<div class="popup zoom-anim-dialog mfp-hide" id="success_order">
    <div class="popup__content">
        <div class="page__block-formtitle text-center">Ваш заказ успешно отправлен</div>
        <div class="popup__actions">
            <a class="page__link" href="{{ route('stocks') }}">В каталог</a>
            <div class="divider">или</div>
            <a class="btn" href="{{ url('/') }}">На главную</a>
        </div>
    </div>
</div>
<div class="popup zoom-anim-dialog mfp-hide" id="popupWindow">
    <div class="popup__content">
        <div class="page__block-formtitle text-center"></div>
    </div>
</div>