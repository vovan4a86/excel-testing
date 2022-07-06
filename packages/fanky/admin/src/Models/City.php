<?php namespace Fanky\Admin\Models;

use Cookie;
use Fanky\Admin\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use View;

/**
 * Class City
 *
 * @property integer id
 * @property string  name
 * @property string  alias
 * @property string  address
 * @property string  text
 * @property string  index_text
 * @property string  title
 * @property string  keywords
 * @property string  description
 * @property boolean on_footer
 * @package Fanky\Admin\Models
 * @property string|null $email
 * @property string $from_form
 * @property string|null $in_form
 * @property string $postal_code
 * @property float|null $lat
 * @property float|null $long
 * @property string|null $contact_text
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\SxgeoCity[] $sxgeo_cities
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereContactText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereFromForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereInForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereIndexText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model {

	protected $fillable = ['name', 'alias', 'postal_code', 'index_text', 'contact_text',
		'email',
		'from_form', 'in_form', 'long', 'lat', 'address'];

	public function sxgeo_cities() {
		return $this->belongsToMany('Fanky\Admin\Models\SxgeoCity');
	}

	/** @return City */
	public static function check_region($alias) {
		$city = self::whereAlias($alias)->first();

		return $city;
	}

	/** return Page */
	public function generateIndexPage() {
		$page = new Page();
		$main_page = Page::find(1);
		$page->parent_id = $main_page->id;

		$page->title = Settings::get('city_index_title');
		$page->keywords = $main_page->keywords;
		$page->description = $main_page->description;
		$page->name = Settings::get('city_index_h1');
//		$page->name = $main_page->name;
		$page->text = $this->index_text;
		//managers
		return $page;
	}

	public function getSchemaOrganization() {
		$sxgeoCity = $this->sxgeo_cities()
			->where('sxgeo_cities.name_ru', $this->name)->first();
		if(!$sxgeoCity){
			$sxgeoCity = $this->sxgeo_cities()
				->orderBy(\DB::raw('LENGTH(okato)'), 'desc')
				->first();
		}

		$region = '';
		$country = '';
		$postalCode = $this->postal_code;
		if ($sxgeoCity && !$postalCode) {
			$region = $sxgeoCity->region->name_ru;
			$country = $sxgeoCity->region->country;
			$postalCode = $sxgeoCity->zip;
		}
		$streetAddress = 'г. ' . $this->name . ', ' . $this->address;

		return view('blocks.schemaOrganization', [
			'phone'         => Settings::get('phone'),
			'city'          => $this->name,
			'streetAddress' => $streetAddress,
			'region'        => $region,
			'country'       => $country,
			'postalCode'    => $postalCode,
		]);
	}

	public static function getDefaultSchemaOrganization() {

		return view('blocks.schemaOrganization', [
			'phone'         => Settings::get('phone'),
			'city'          => 'Федеральный',
			'streetAddress' => '',
			'region'        => '',
			'country'       => '',
			'postalCode'    => '',
		]);
	}

	public static function current($city_alias = null, $remember = true, \Illuminate\Http\Request $request) {
//		$detect_city = SxgeoCity::detect();
		$first_visit = (Cookie::has('city_id')) ? false : true;
		$federal_link = $city_alias ? false : true;
		$city = null;
		$region_page = true; //СТраница участвует в региональности
		$segments = $request->segments();
		if(count($segments) > 0){
			$start = array_shift($segments);
			if(in_array($start, Page::$excludeRegionAlias)){
				$region_page = false;
			}
		}

//		Проверка на главную страницу
		if (Request::path() == '/') {
			if ($city_alias = session('city_alias')) {
				return City::whereAlias($city_alias)->first();
			} else {
				$detect_city = SxgeoCity::detect();
				if (!$first_visit) { //если не первый визит
					$city_id = Cookie::get('city_id');
					$city = City::find($city_id);
					if ($city) { //если не первый визит и такой город есть, ничего не выводим
						session(['city_alias' => $city->alias]);

						return $city;
					} else if ($city_id === 0 || $city_id === '0') {
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
				if ($remember) {
					session(['city_alias' => null]);
				}

			} else {
				View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
				if ($remember) {
					session(['city_alias' => $city_alias]);
				}
				$city = City::whereAlias($city_alias)->first();
			}
		} else {
			$city_id_by_cookie = Cookie::get('city_id', null);

			if ($federal_link) {

				if ($city_id_by_cookie === 0 || $city_id_by_cookie === '0') { //Ничего не показываем, оставляем как есть
					if ($remember) {
						session(['city_alias' => '']);
					}

					return null;
				} else { //Показываем большое окно - Вы у нас уже были, но в другом регионе
					$city_by_cookie = City::whereId(Cookie::get('city_id'))->first();
					if ($city_by_cookie && $region_page) {
						View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
						View::share('big_region_confirm_city', $city_by_cookie);
						if ($remember) {
							session(['city_alias' => $city_alias]);
						}
					}

					$city = City::whereId($city_id_by_cookie)->first();

				}
			} else { //!federal_link
				$city_by_alias = City::whereAlias($city_alias)->first();
				if ($city_by_alias->id == $city_id_by_cookie) { //если регион совпадает с ранее сохраненным.
					if ($remember) {
						session(['city_alias' => $city_by_alias->alias]);
					}
				} else { //Если попали на другой регион
					$city_by_cookie = City::whereId(Cookie::get('city_id'))->first();
					if ($city_by_cookie && $region_page) { //город из куков в базе есть, но не совпадает с раннее выбранным
						View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
						View::share('big_region_confirm_city', $city_by_cookie);
						if ($remember) {
							session(['city_alias' => $city_alias]);
						}

					} else { //города из куков в базе нет. покажем маленькое окно
						View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
						if ($remember) {
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
