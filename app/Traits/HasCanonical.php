<?php namespace App\Traits;
use Illuminate\Support\Str;
use Image;
use Settings;
use Thumb;

/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 19.12.2017
 * Time: 11:09
 */


trait HasCanonical{

	public function setCanonical() {
	    if(count(\Request::query())){
	        \SEOMeta::setCanonical($this->url);
        }
	}
}