<?php

namespace Fanky\Admin;

class Parser {
    private $curl;
    private $host;

    //
    //  Инициализация класса для конкретного домена
    //
    public static function app($host): Parser {
        return new self($host);
    }

    private function __construct($host){
        $this->curl = curl_init();
        $this->host = $host;
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct(){
        curl_close($this->curl);
    }

    //set options
    public function set($name, $value): Parser {
        curl_setopt($this->curl, $name, $value);
        return $this;
    }

    public function https($act): Parser {
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $act);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, $act);
        return $this;
    }

    //запросы с хоста
    public function request($url): array {
        curl_setopt($this->curl, CURLOPT_URL, $this->make_url($url));
        $data = curl_exec($this->curl);
        return $this->process_result($data);
    }

    public function config_load(){

    }

    public function config_save($file){

    }

    private function make_url($url): string {
        if($url[0] != '/')
            $url = '/' . $url;

        return $this->host . $url;
    }

    private function process_result($data): array {
        $p_n = "\n";
        $p_rn = "\r\n";

        $h_end_n = strpos($data, $p_n . $p_n);    // int - false
        $h_end_rn = strpos($data, $p_rn . $p_rn); // int - false

        $start = $h_end_n; // h_end_n int
        $p = $p_n;		 // \n

        if($h_end_n === false || $h_end_rn < $h_end_n){
            $start = $h_end_rn;
            $p = $p_rn;
        }

        $headers_part = substr($data, 0, $start);
        $body_part = substr($data, $start + strlen($p) * 2);

        $lines = explode($p,$headers_part);
        $headers = array();

        $headers['start'] = $lines[0];

        for($i = 1; $i < count($lines); $i++){
            $del_pos = strpos($lines[$i], ':');
            $name = substr($lines[$i], 0, $del_pos);
            $value = substr($lines[$i], $del_pos + 2);
            $headers[$name] = $value;
        }

        return array(
            'headers' => $headers,
            'html' => $body_part
        );
    }
}
