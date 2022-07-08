<?php

	namespace Fanky\Admin;

	class Parser {

		private $curl; //экземпляр curl
		private $host; //базовая часть урла без слэша на конце
		public $curl_settings;

		public static function app($host): Parser {
			return new self($host);
		}

		private function __construct($host) {
			$this->curl = curl_init();
			$this->host = $host;
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true); // возвращать данные без вывода на экран
		}

		public function __destruct() {
			curl_close($this->curl);
		}

		//сохранение конфигурации
		public function config_save($file) {
			$data = serialize($this->curl_settings);
			file_put_contents($file, $data);
		}

		//загрузка конфигурации
		public function config_load($file): Parser {
			$data = file_get_contents($file);
			$data = unserialize($data);

			curl_setopt_array($this->curl, $data);

			foreach ($data as $key => $val) {
				$this->curl_settings[$key] = $val;
			}
			return $this;
		}

		//установить настройку curl
		public function set($name, $value): Parser {
			$this->curl_settings[$name] = $value;
			curl_setopt($this->curl, $name, $value);
			return $this;
		}

		public function request($url): array {
			curl_setopt($this->curl, CURLOPT_URL, $this->make_url($url));
			$data = curl_exec($this->curl);
			return $this->process_result($data);
		}

		//показать заголовки запроса
		public function headers($act): Parser {
			$this->set(CURLOPT_HEADER, $act);
			return $this;
		}

		//вкл.выкл возможность обращаться к https страницам
		public function ssl($act): Parser {
			$this->set(CURLOPT_SSL_VERIFYPEER, $act); //true default
			$this->set(CURLOPT_SSL_VERIFYHOST, $act); //только 2?
			return $this;
		}

		// false - откл. обращение методом POST
		//->follow(1) - перейдет в личный кабинет, 0 - без редиректа
		//пример:
		//	 $simple = Parser::app('https://medexe.ru/')
		//		->headers(1)
		//		->follow(false)
		//		->cookie('my_simple.txt');
		//как использовать:
		//$data = simple->request('client/login')	//post метод сработает
		//$data = simple->post(false)-request('client/office') //get
		public function post($data): Parser {
			if ($data == false) {
				$this->set(CURLOPT_POST, false);
				return $this;
			}
			$this->set(CURLOPT_POST, true);
			$this->set(CURLOPT_POSTFIELDS, http_build_query($data)); // строит запрос вида email=email&password=pass...
//			$data = ['email' => 'admin@mail.ru', 'password' => 'qwerty', 'remember' => 'on']; //пример формирования $data
			return $this;
		}

		//устанавливает настройки куков
		//$file относительный путь до файла
		public function cookie($file): Parser {
			$this->set(CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . $file);
			$this->set(CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . $file);
			return $this;
			//для чего: подключаемся к хосту с авторизацией методом POST и затем сохраняем куки для повторного использования
		}

		//добавить заголовок
		public function add_header($header): Parser {
			$this->curl_settings[CURLOPT_HTTPHEADER][] = $header;
			$this->set(CURLOPT_HTTPHEADER, $this->curl_settings[CURLOPT_HEADER]);
			return $this;
		}

		//добавить массив заголовков
		public function add_headers($headers): Parser {
			foreach ($headers as $header) {
				$this->curl_settings[CURLOPT_HEADER][] = $header;
			}

			$this->set(CURLOPT_HTTPHEADER, $this->curl_settings[CURLOPT_HEADER]);
			return $this;
		}

		public function clear_headers(): Parser {
			$this->curl_settings[CURLOPT_HTTPHEADER] = array();
			$this->set(CURLOPT_HTTPHEADER, $this->curl_settings[CURLOPT_HEADER]);
			return $this;
		}

		// следовать ли за перенаправлением true/false
		public function follow($param): Parser {
			$this->set(CURLOPT_FOLLOWLOCATION, $param);
			return $this;
		}

		//установить referer
		public function referer($url): Parser {
			$this->set(CURLOPT_REFERER, $url);
			return $this;
		}

		//установить user agent
		public function user_agent($agent): Parser {
			$this->set(CURLOPT_USERAGENT, $agent);
			return $this;
		}

		//случайный user agent
		public function random_agent(): Parser {
			$agents = [
				'Mozilla Firefox 36 (Win 8.1 x64): Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
				'Google Chrome 53 (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36',
				'Google Chrome 40 (Win 8.1 x64): Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36',
				'Opera 40 (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.101 Safari/537.36 OPR/40.0.2308.62',
				'Opera 12.17 (Win 8 x64): Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.17',
				'Apple Safari 5.1 (Win 8 x64): Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
				'Internet Explorer 11 (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; rv:11.0) like Gecko',
				'Internet Explorer 11 (Win 8.1 x64): Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; ASU2JS; rv:11.0) like Gecko',
				'Microsoft Edge (Win 10 x64): Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586',
			];
			$int = rand(0, count($agents) - 1);
			$this->set(CURLOPT_USERAGENT, $agents[$int]);
			return $this;
		}

		//формирование правильного url
		public function make_url($url): string {
			if ($url[0] != '/')
				$url = '/' . $url;
			return $this->host . $url;
		}

		//разделение заголовков от тела и формирование ответа
		private function process_result($data): array {
			//если в запросе заголовки отключены
			if (!isset($this->curl_settings[CURLOPT_HTTPHEADER]) || !$this->curl_settings[CURLOPT_HEADER]) {
				return array(
					'headers' => array(),
					'html' => $data
				);
			}
			//если включены
			// ищем \n или \r\n, т.е. пустую строку, разделяющую заголовок ответа от тела
			$p_n = "\n";
			$p_rn = "\r\n";

			$h_end_n = strpos($data, $p_n . $p_n); //проверка если есть сивол переноса строки, то данные с заголовком
			$h_end_rn = strpos($data, $p_rn . $p_rn); // тоже самое

			$start = $h_end_n; // место переноса \n
			$p = $p_n; // запоминаем в р

			// если \n не найден и \r\n встретится раньше \n значит вот он разделитель заголовка
			if ($h_end_n == false || $h_end_rn < $h_end_n) {
				$start = $h_end_rn; // запоминаем его начало
				$p = $p_rn; // запоминаем его знак
			}

			$header_part = substr($data, 0, $start); // запоминаем заголовок
			$body_part = substr($data, $start + strlen($p) * 2); // запоминаем тело от start + 2ой пернос строки(т.е пустая строка)]]\\

			$lines = explode($p, $header_part); //разбиваем заголовок по $p(\n || \r\n)
			$headers = array();

			$headers['start'] = $lines[0]; //первая строка с кодом ответа сервера

			for ($i = 1; $i < count($lines); $i++) {
				$del_pos = strpos($lines[$i], ':'); // находим первый :
				$name = substr($lines[$i], 0, $del_pos); // сохр имя до :
				$value = substr($lines[$i], $del_pos + 2); // сохр значение после ': ' поэтому +2
				$headers[$name] = $value;
			}

			return array(
				'headers' => $headers,
				'html' => $body_part
			);
		}
	}
