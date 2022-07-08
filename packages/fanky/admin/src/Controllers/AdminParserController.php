<?php namespace Fanky\Admin\Controllers;

use App\Http\Controllers\Controller;
use Fanky\Admin\Parser;
use KubAT\PhpSimple\HtmlDomParser;

class AdminParserController extends Controller {

	//https://medexe.ru/production/details/taps/price.html
	public function main() {

//		array(
//				0 => "Отвод"
//				1 => "45-1-48,3х3,6"
//				2 => "ст.12х18н10т"
//				3 => "геом."
//				4 => "по"
//				5 => "ГОСТ"
//				6 => "17375"
//				7 => ""
//		)
		//   regex(45|60|90)\S = name
//		$arr = $this->parseName('Отвод 45-1-48,3х3,6 ст.12х18н10т геом. по ГОСТ 17375');
//		$name = $arr[1];
//		$steel = $arr[2];
//		$gost = '';
//		for ( $i=0; $i<count($arr); $i++) {
//			if(in_array($arr[$i], ['ГОСТ', 'DIN', 'ISO'])) {
//				$gost = implode(' ', [$arr[$i], $arr[$i + 1]]);
//				break;
//			}
//		}
//		$result = "$name | $steel | $gost";

//		dd($result);

		$parserMedexe = Parser::app('https://medexe.ru/')
			->headers(1)
			->follow(true)
//						->user_agent('Google Chrome 53 (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36')
			->random_agent()
			->referer('https://yandex.ru');

		$html = $parserMedexe->request('production/details/taps/price.html');

		$dom = HtmlDomParser::str_get_html($html['html']);

		//найти первый(0) '.price-title1', затем в нем первый(0) '.item'
		$price1 = $dom->find('.price-title1', 0)->find('.item', 0)->text();
		$totalNum = preg_replace('/[^\d]+/', '', $price1);
		echo "Наименований на сайте: $totalNum <br>";

		$date = $dom->find('.price-title1', 0)->find('.item', 1)->find('span', 0)->text();
		echo "Дата: $date <br>";
		echo "<hr>";

//				$pages = $totalNum / 20;

		for ($i = 1; $i <= 1; $i++) {
			$html = $parserMedexe->request('production/details/taps/price.html?curPos=' . $i * 20);
			$dom = HtmlDomParser::str_get_html($html['html']);

			$items = $dom->find('.price-table .item');

			foreach ($items as $item) {
				$name = $item->find('.item-name', 0)->text();
				$priceRaw = $item->find('.item-price', 0)->text();
				$priceClean = preg_replace('/[^\d]+/', '', $priceRaw);
				$stockValue = $item->find('.item-stock', 0)->find('span', 0)->text();
				$inStock = strpos($stockValue, 'наличии') ? 1 : 0;
				echo $name . " - ";
				echo $priceClean . " inStock =  ";
				echo $inStock . "<br>";
			}
			echo "Page: $i / 1" . "<hr>";
		}
	}

	public function parseName($string) {
		$r = explode(' ', $string);
		return $r;
	}

}
