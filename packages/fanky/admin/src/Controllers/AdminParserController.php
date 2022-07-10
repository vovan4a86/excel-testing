<?php namespace Fanky\Admin\Controllers;

use App\Http\Controllers\Controller;
use Fanky\Admin\Models\ParseItem;
use Fanky\Admin\Parser;
use KubAT\PhpSimple\HtmlDomParser;

class AdminParserController extends Controller {

    const PAGES_UPLOAD_URL = '/uploads/pages/';
	//https://medexe.ru/production/details/taps/price.html
	public function main() {
		$parserMedexe = Parser::app('https://medexe.ru/')
			->headers(1)
			->follow(true)
            ->user_agent('Google Chrome 53 (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36')
//			->random_agent()
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

        $pages = $totalNum / 20 + 1;

        ParseItem::truncate();
		for ($i = 1; $i <= $pages; $i++) {
			$html = $parserMedexe->request('production/details/taps/price.html?curPos=' . $i * 20);
			$dom = HtmlDomParser::str_get_html($html['html']);

			$items = $dom->find('.price-table .item');

			foreach ($items as $item) {
                $inStockValue = $item->find('.item-stock', 0)->find('span', 0)->text();
                $inStock = strpos($inStockValue, 'наличии') ? 1 : 0;
                if($inStock) {
                    $nameString = $item->find('.item-name', 0)->text();
                    $priceRaw = $item->find('.item-price', 0)->text();
                    $priceClean = preg_replace('/[^\d]+/', '', $priceRaw);

                    $parseString = $this->parseName($nameString);
                    $parseString['price'] = $priceClean;

                    ParseItem::create($parseString);
                }
			}
		}
        echo "Page: $i/$pages is parsed" . "<hr>";
    }

	public function parseName($string): array {
        $result = [];
        if(preg_match('/(DIN)/', $string)) {
            preg_match('/90-\d{2,3}\s\S+/', $string, $matches);
            $matches ? $result['name'] = $matches[0] : $result['name'] = '';
            preg_match('/AISI\s\d+/', $string, $matches);
            $matches ? $result['steel'] = $matches[0] : $result['steel'] = '';
            $result['gost'] = 'DIN';
        } else if(preg_match('/(ISO)/', $string)) {
            preg_match('/90-\d{2,3}\s\S+/', $string, $matches);
            $matches ? $result['name'] = $matches[0] : $result['name'] = '';
            preg_match('/AISI\s\d+/', $string, $matches);
            $matches ? $result['steel'] = $matches[0] : $result['steel'] = '';
            $result['gost'] = 'ISO';
        } else {
            preg_match('/(30|45|60|90)\S+/', $string, $matches);
            $matches ? $result['name'] = $matches[0] : $result['name'] = '';
            preg_match('/ст\.\S+/', $string, $matches);
            $matches ? $result['steel'] = $matches[0] : $result['steel'] = '';
            preg_match('/ГОСТ\s\d+/', $string, $matches);
            $matches ? $result['gost'] = $matches[0] : $result['gost'] = '';
        }
        return $result;
	}

}
