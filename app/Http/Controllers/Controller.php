<?php namespace App\Http\Controllers;

use App;
use Request;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
	public $city = null;
	use DispatchesJobs, ValidatesRequests;
	public function add_region_seo($page) {
		$current_city = App::make('CurrentCity');
		$this->city = $current_city && $current_city->id ? $current_city: null;
		if($this->city){
			$page->title .= ' в ' . $this->city->in_form;
			$page->keywords .= ' в ' . $this->city->in_form;
			$page->description .= ' в ' . $this->city->in_form;
			$page->name .= ' в ' . $this->city->in_form;
			if($page->h1){
				$page->h1 .= ' в ' . $this->city->in_form;
			}
		} else {
			$page->title .= ' в Екатеринбурге';
			$page->keywords .= ' в Екатеринбурге';
			$page->description .= ' в Екатеринбурге';
			$page->name .= ' в Екатеринбурге';
			if($page->h1){
				$page->h1 .= ' в Екатеринбурге';
			}
		}
		return $page;
	}

	/**
	 * @param Carbon $lastModifed
	 * @return NULL|\Illuminate\Contracts\Routing\ResponseFactory|null|\Symfony\Component\HttpFoundation\Response
	 */
	public function checkLastmodify($lastModifed){
		if(Request::hasHeader('If-Modified-Since')){
			$timestamp = Request::header('If-Modified-Since');
			$timestamp = Carbon::createFromFormat("D, d M Y H:i:s T", $timestamp);
			if($lastModifed->between($timestamp->copy()->subMinute( 1),
				$timestamp->copy()->addMinute(1))) return response('', 304);
		}

		return null;
	}
}
