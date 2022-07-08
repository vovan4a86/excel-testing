<?php namespace Fanky\Admin\Controllers;

use App\Http\Controllers\Controller;
use Fanky\Admin\Parser;

class AdminParserController extends Controller {

	public function main() {
        $parserInstance = Parser::app('https://ru.wikipedia.org/')
            ->set(CURLOPT_HEADER, 1) //получать заголовки в ответе
            ->set(CURLOPT_REFERER, 'google.com');

        $html = $parserInstance->request('wiki/Днепрогэс');
        echo $html['html'];
	}

}
