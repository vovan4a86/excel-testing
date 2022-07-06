@extends('template')
@section('main')
    <x-breadcrumbs :items="$bread" />
    <div class="container container--inner">
        <x-catalog-aside :items="$leftMenuItems" />
        <main class="main main--inner">
            <section class="section section--dark category">
                <div class="container">
                    <h1 class="page-title">{{ $h1 }}</h1>
                    <ul class="category__list">
                        @foreach($children as $child)
                            <li>
                                <a href="{{ $child->url }}">{{ $child->name }}</a>
                                @if(count($child->public_children))
                                    <ul class="category__sublist">
                                        @foreach($child->public_children as $child2)
                                            <li>
                                                <a href="{{ $child->url }}">{{ $child2->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </main>
    </div>
    <section class="section section--gradient category-list">
        <div class="container">
            <div class="page-title">Весь каталог</div>
            <nav class="category-list__content">
                <ul class="category-list__menu">
                    <li class="category-list__head">
                        <a href="javascript:void(0)">Трубный прокат</a>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба профильная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Профильная труба квадратная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба 09Г2С</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Профильная труба ГОСТ</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 13663-86</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8645-68</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 30245-2003</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 25577-83</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8639-82</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба профильная прямоугольная</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8645-68</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 13663-86</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба оцинкованная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба оцинкованная электросварная</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10704-91</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10706-76</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 3265-76</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба электросварная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба электросварная ГОСТ 10704-94</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба электросварная профильная</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба горячекатаная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ГОСТ 8732-78</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3-1128-2000</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-161-184-2000</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3P-44-2001</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3Р-50-2001</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3Р-55-2001</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3-1430-2007</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба магистральная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба магистральная прямошовная 159-426 мм</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба магистральная спиралешовная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба магистральная прямошовная 530-820 мм</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба ВГП</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба ВГП ГОСТ</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 3262-75</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 380-88</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 1050-8</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба круглая</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ГОСТ 10705-80</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ГОСТ 20295-85</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ГОСТ 10704-91</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 1308-135-0147016-01</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 1303-006.3-593377520-2003</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 1383-001-12281990-2004</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">ТУ 14-3P-1471-2002</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба стальная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Труба прямошовная</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10704-91</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10705-80</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10706-76</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Сортамент стальных труб</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8732 78</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 10704 91</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Труба бесшовная</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Холоднодеформированная</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8733-78</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Теплодеформированная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Горячедеформированная</a>
                                <ul class="category-list__inner">
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8731-74</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ 8732-78</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">ГОСТ Р 53383-2009</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__head">
                        <a href="javascript:void(0)">Сортовой прокат</a>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Арматура</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Рабочая</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Конструктивная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Распределительная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Монтажная</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Анкерная</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Швеллер</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Швеллер стальной</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Гнутый стальной швеллер</a>
                            </li>
                        </ul>
                    </li>
                    <li class="category-list__catalog">
                        <a href="javascript:void(0)">Уголок</a>
                        <ul class="category-list__subitem">
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Горячекатаный</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Холоднокатаный</a>
                            </li>
                            <li class="category-list__subcatalog">
                                <a href="javascript:void(0)">Уголки гнутые из листового проката</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
@endsection