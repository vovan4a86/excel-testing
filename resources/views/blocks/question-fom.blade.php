<form class="map__form form" action="{{ route('ajax.question') }}" onsubmit="sendCallback(this, event)">
    <div class="form__title">Есть вопросы? Пишите, ответим в ближайшее время!</div>
    <div class="form__container">
        <div class="form__column">
            <input type="text" name="name" placeholder="Ваше имя" aria-label="Ваше имя" required>
            <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" aria-label="Ваш телефон"
                   required>
            <input type="text" name="email" placeholder="E-mail" aria-label="E-mail">
        </div>
        <div class="form__column">
            <textarea name="text" placeholder="Сообщение" aria-label="Сообщение"></textarea>
        </div>
        <div class="form__column">
            <button class="btn">Отправить сообщение</button>
            <div class="form__policy">Нажимая кнопку &laquo;Отправить сообщение&raquo;, вы&nbsp;соглашаетесь
                с&nbsp;
                <a class="policy" href="{{ url('policy') }}" target="_blank">политикой конфиденциальности</a>
            </div>
        </div>
    </div>
</form>
