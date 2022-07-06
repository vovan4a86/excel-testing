<ul class="section__links links" aria-label="Меню страницы">
    <li class="links__item">
        <a class="links__link {{ Route::is('news*') ? 'links__link--current': '' }}" href="{{ route('news') }}" title="Новости" aria-label="Новости">Новости</a>
    </li>
    <li class="links__item">
        <a class="links__link" href="events-page.html" title="События" aria-label="События">События</a>
    </li>
</ul>