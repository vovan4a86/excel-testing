<?php

namespace App\Repositories;

use Cookie;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\SxgeoCity;
use Request;
use View;

class CityRepository implements Interfaces\CityRepositoryInterface {
    private $_listById, $_listByAlias = [];

    public function getById($id, $allowCached = true) {
        if($id == 0) return 0;
        if(!isset($this->_listById, $id) || !$allowCached) {
            $this->_listById[$id] = City::find($id);
        }

        return array_get($this->_listById, $id, null);
    }

    public function getByAlias(string $alias, $allowCached = true) {
        if(!isset($this->_listByAlias, $id) || !$allowCached) {
            $this->_listByAlias[$alias] = City::where('alias', $alias)->first();
        }

        return array_get($this->_listByAlias, $alias, null);
    }

    public function current($city_alias = null, $remember = true, \Illuminate\Http\Request $request = null){
        $request = $request ?: Request::instance();
        $detect_city = SxgeoCity::detect();
        $first_visit = (Cookie::has('city_id')) ? false : true;
        $federal_link = $city_alias ? false : true;
        $city = null;
        $region_page = true; //СТраница участвует в региональности
        $segments = $request->segments();
        if(count($segments) > 0){
            $start = array_shift($segments);
            if(in_array($start, Page::$excludeRegionAliases)){
                $region_page = false;
            }
        }
        //Проверка на главную страницу
        if ($request->path() == '/') {
            if ($city_alias = session('city_alias')) {
                return $this->getByAlias($city_alias);
            } else {
                if (!$first_visit) { //если не первый визит
                    $city_id = Cookie::get('city_id');
                    $city = $this->getById($city_id);
                    if ($city) { //если не первый визит и такой город есть, ничего не выводим
                        session(['city_alias' => $city->alias]);

                        return $city;
                    } else if($city_id === 0) {
                        session(['city_alias' => '']);

                        return null;
                    } else {//если не первый визит и такого города выводим свой город и показываем окно,

                        View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке

                        return $detect_city;
                    }
                } else { //Если первый визит - город ставим автоматом, выводим окно в шапке
                    if ($detect_city) {
                        session(['city_alias' => $detect_city->alias]);
                        View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
                    }

                    return $detect_city;
                }
            }
        }
        //обработка остальных ссылок

        if ($first_visit) {
            if ($federal_link) {
                if($remember){
                    session(['city_alias' => null]);
                }

            } else {
                View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
                if($remember) {
                    session(['city_alias' => $city_alias]);
                }
                $city = $this->getByAlias($city_alias);
            }
        } else {
            $city_id_by_cookie = Cookie::get('city_id', null);

            if ($federal_link) {

                if ($city_id_by_cookie === 0) { //Ничего не показываем, оставляем как есть
                    if($remember) {
                        session(['city_alias' => '']);
                    }

                    return null;
                } else { //Показываем большое окно - Вы у нас уже были, но в другом регионе
                    $city_by_cookie = $this->getById(Cookie::get('city_id'));
                    if ($city_by_cookie && $region_page) {
                        View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
                        View::share('big_region_confirm_city', $city_by_cookie);
                        if ($remember) {
                            session(['city_alias' => $city_alias]);
                        }
                    }

                    $city = $this->getById($city_id_by_cookie);

                }
            } else { //!federal_link
                $city_by_alias = $this->getByAlias($city_alias);
                if($city_by_alias->id == $city_id_by_cookie){ //если регион совпадает с ранее сохраненным.
                    if($remember) {
                        session(['city_alias' => $city_by_alias->alias]);
                    }
                } else { //Если попали на другой регион
                    $city_by_cookie = $this->getById(Cookie::get('city_id'));
                    if($city_by_cookie && $region_page){ //город из куков в базе есть, но не совпадает с раннее выбранным
                        View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
                        View::share('big_region_confirm_city', $city_by_cookie);
                        if($remember) {
                            session(['city_alias' => $city_alias]);
                        }

                    } else { //города из куков в базе нет. покажем маленькое окно
                        View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
                        if($remember) {
                            session(['city_alias' => $city_alias]);
                        }
                    }
                }

                $city = $city_by_alias;
            }
        }

        return $city;
    }
}