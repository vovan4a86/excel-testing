/// init
document.addEventListener('DOMContentLoaded', () => {
  new Blazy();

  function toFixedTable() {
    const summary = document.querySelectorAll('[data-summary]');

    if (summary) {
      summary.forEach(value => {
        value.textContent = parseFloat(value.textContent).toFixed(2);
      });
    }
  }

  toFixedTable();
  wrappTables();
  initContactsMaps();

  ////
  $('a.policy').magnificPopup({
    type: 'ajax',
    alignTop: true,
    overflowY: 'scroll',
    preloader: true,
    midClick: true,
    removalDelay: 300,
    mainClass: 'mfp-with-zoom mfp-img-mobile'
  });

  ////
  $(document).magnificPopup({
    delegate: 'a.popup',
    type: 'inline',
    fixedContentPos: true,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: false,
    midClick: true,
    removalDelay: 300,
    mainClass: 'zoom-in mfp-img-mobile'
  });

  ////
  $('.map-open').magnificPopup({
    type: 'inline',
    fixedContentPos: true,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: false,
    preloader: true,
    midClick: true,
    removalDelay: 300,
    mainClass: 'my-mfp-zoom-in mfp-img-mobile',
    callbacks: {
      open: function () {
        const id = 'map';
        const map = document.getElementById(id);
        const yMap = map.querySelector('ymaps');

        if (map && !yMap) {
          const long = map.dataset.long;
          const lat = map.dataset.lat;
          const hint = map.dataset.hint;

          initmap(id, lat, long, 16, hint);
        }
      }
    }
  });

  ////
  $('.lightbox').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    removalDelay: 500,
    mainClass: 'mfp-with-zoom mfp-img-mobile',
    image: {
      verticalFit: true,
      titleSrc: function (item) {
        return item.el.attr('title');
      }
    },
    zoom: {
      enabled: true,
      duration: 300,
      opener: function (element) {
        return element.find('img');
      }
    },
    midClick: true
  });

  ////
  $('.gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: true,
    mainClass: 'mfp-with-zoom mfp-img-mobile',
    image: {
      verticalFit: true,
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
      titleSrc: function (item) {
        return item.el.attr('title');
      }
    },
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      tCounter: '',
      preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
    },
    zoom: {
      enabled: true,
      duration: 300, // don't foget to change the duration also in CSS
      opener: function (element) {
        return element.find('img');
      }
    }
  });

  ////
  $('img, a').on('dragstart', function (e) {
    e.preventDefault();
  });

  ////
  $('input[type="tel"], input[name="tel"]').inputmask('+7 (999) 999-99-99');
  $('input[name="email"]').inputmask('email');

  ////
  $('.js-select').selectize();

  ////
  $('.aside-nav__link')
    .filter('[href="' + window.location + '"]')
    .addClass('aside-nav__link--active')
    .closest('.aside-nav__container')
    .addClass('showed-up');
  $('.nav__link')
    .filter('[href="' + window.location + '"]')
    .addClass('nav__link--active')
    .closest('.nav__item')
    .addClass('nav__item--active');
  $('.page-nav__link')
    .filter('[href="' + window.location + '"]')
    .addClass('active');

  const asideLinks = document.querySelectorAll('.aside-nav__link');

  if (asideLinks) {
    asideLinks.forEach(link => {
      const url = window.location.href;
      const trimmedUrl = url.slice(0, url.lastIndexOf('/'));
      const menuLinkUrl = link.getAttribute('href');

      if (menuLinkUrl === trimmedUrl) {
        link.closest('.js-aside').classList.add('showed-up');
        link.classList.add('aside-nav__link--active');
        link.classList.add('is-clicked');
      }
    });
  }

  ////
  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 300) {
      $('.scrolltop').addClass('scrolltop--show');
    } else {
      $('.scrolltop').removeClass('scrolltop--show');
    }
  });

  ////
  $('.scrolltop').on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 0);
  });

  ////
  $('.headermob__subnav').on('click', function () {
    $(this).find('.headermob__sublist').slideToggle();
    $(this).toggleClass('active');
  });

  ////
  const collapsedTriggers = $('[data-collapsed]');

  collapsedTriggers.on('click', function () {
    $(this).toggleClass('active');
    $(this).siblings('[data-content]').slideToggle();
  });

  collapsedTriggers.each(function () {
    $(this).trigger('click');
  });

  ////
  $('[data-spoiler]').on('click', function () {
    $(this).toggleClass('active');
    $(this).siblings('[data-content]').slideToggle();
  });

  ////
  $('.tabs__link').on('click', function (e) {
    e.preventDefault();

    $('.tabs__link').removeClass('active');
    $('.tabs__item').removeClass('active');

    $(this).addClass('active');
    $($(this).attr('href')).addClass('active');
  });

  $('.tabs__link:first').trigger('click');

  ////
  // init functions
  const headerCities = document.querySelectorAll('.header__city');
  const asideNavigation = document.querySelector('.aside-nav');
  const burger = document.querySelector('.hamburger');
  const map = document.querySelector('.js-map');
  const inputs = document.querySelectorAll('[type="number"]');
  const orderLink = document.querySelector('[data-order]');

  if (headerCities) phoneSwitcher(headerCities);
  if (asideNavigation) asideNav(asideNavigation);
  if (burger) burgerInit(burger);
  if (map) mapSwitcher(map);
  if (inputs) checkInputs(inputs);
  if (orderLink) orderInit(orderLink);

  preloader();
  currentYear();
  initAsideMap();
});

////
const burgerInit = prop => {
  prop.addEventListener('click', mobileMenu);

  function mobileMenu() {
    this.classList.toggle('is-active');

    const mobileContent = document.querySelector('.headermob__content');

    if (mobileContent) {
      mobileContent.classList.toggle('opened');

      document.body.classList.toggle('no-scroll');

      setMargin(this, mobileContent);
      setOverlay(this);
    }
  }

  function setMargin(parent, block) {
    const container = parent.closest('.headermob');
    const height = container.offsetHeight;

    block.style.marginTop = `${height - 1}px`;
  }

  function setOverlay(container) {
    container.closest('.headermob').classList.toggle('headermob--overlay');
  }
};

////
const phoneSwitcher = prop => {
  prop.forEach(switcher => switcher.addEventListener('click', switchPhones));

  function switchPhones() {
    prop.forEach(switcher => switcher.classList.remove('header__city--active'));

    this.classList.add('header__city--active');

    // get data
    const code = this.dataset.code;
    const phone = this.dataset.phone;
    const link = this.dataset.link;

    // write data
    if (code && phone && link) writeData(code, phone, link);
  }

  function writeData(code, phone, link) {
    const outputPhone = document.querySelector('.header__phone a');
    const outputCode = document.querySelector('.header__code');

    outputCode.textContent = `(${code})`;
    outputPhone.textContent = phone;
    outputPhone.setAttribute('href', `tel:${link}`);
  }
};

////
const mapSwitcher = prop => {
  prop.addEventListener('click', switchCity);

  function switchCity(e) {
    const target = e.target.dataset.link;
    const link = e.target.closest('.map__item');

    if (target && link) {
      removeActiveLinks();

      prop.querySelector(`.map__city--${target}`).classList.add('is-active');
      link.classList.add('is-active');
    }
  }

  function removeActiveLinks() {
    const mapLinks = document.querySelectorAll('[data-city-active]');

    mapLinks.forEach(link => link.classList.remove('is-active'));
  }
};

////
const asideNav = prop => {
  prop.addEventListener('click', function (e) {
    const target = e.target;

    if (target.classList.contains('aside-nav__title') && target.closest('.js-aside').classList.contains('showed-up')) {
      e.preventDefault();

      target.closest('.js-aside').classList.remove('showed-up');
    } else if (target.classList.contains('aside-nav__title') && target.closest('.js-aside')) {
      e.preventDefault();

      removeActiveAside();
      target.closest('.js-aside').classList.add('showed-up');
    }
  });

  function removeActiveAside() {
    const asideNav = document.querySelectorAll('.aside-nav__container');

    for (let i = 0; i < asideNav.length; i++) {
      asideNav[i].classList.remove('showed-up');
    }
  }
};

////
const currentYear = () => {
  const year = document.querySelector('.footer__year span');

  if (year) setYear(year);

  function setYear(block) {
    const date = new Date();
    block.textContent = date.getFullYear();
  }
};

////
const checkInputs = prop => {
  prop.forEach(input => input.addEventListener('input', check));

  function check() {
    if (this.value < 1) this.value = 1;
  }
};

////
function orderInit(prop) {
  prop.addEventListener('click', createOrder);

  function createOrder() {
    const productName = this.dataset.product;

    // popup data
    const popup = document.getElementById('order');

    if (popup) {
      const popupTitle = popup.querySelector('.popup__title');
      const formData = popup.querySelector('input[name="product"]');

      popupTitle.textContent = productName;
      formData.value = productName;
    }
  }
}

////
const preloader = () => {
  $('.preloader').fadeOut();
  $('body').removeClass('no-scroll');
};

////
function closePopup() {
  $.magnificPopup.close();
}

////
function initmap(idmap, lat, lon, zoom, text) {
  ymaps.ready(function () {
    var myMap = new ymaps.Map(
        idmap,
        {
          center: [lat, lon],
          zoom: zoom,
          controls: ['zoomControl']
        },
        {
          searchControlProvider: 'yandex#search'
        }
      ),
      myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
        hintContent: text,
        balloonContent: text
      });

    myMap.controls.remove('geolocationControl'); // удаляем геолокацию
    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable('scrollZoom');

    if (window.innerWidth < 600) myMap.behaviors.disable('drag');
  });
}

////
function initAsideMap() {
  const id = 'aside-map';
  const map = document.getElementById(id);

  if (map) {
    const long = map.dataset.long;
    const lat = map.dataset.lat;
    const hint = map.dataset.hint;

    initmap(id, lat, long, 15, hint);
  }
}

////
function initContactsMaps() {
  const maps = document.querySelectorAll('.contacts__pin');
  if (maps) initMaps(maps);

  function initMaps(props) {
    props.forEach(map => {
      const id = map.id;
      const long = map.dataset.long;
      const lat = map.dataset.lat;
      const hint = map.dataset.hint;

      initmap(id, lat, long, 17, hint);
    });
  }
}

////
const wrappTables = () => {
  let tables = document.getElementsByTagName('table'),
    length = tables.length,
    i,
    wrapper;

  for (i = 0; i < length; i++) {
    wrapper = document.createElement('div');
    wrapper.setAttribute('class', 'hscroll');
    tables[i].parentNode.insertBefore(wrapper, tables[i]);
    wrapper.appendChild(tables[i]);
  }
};
