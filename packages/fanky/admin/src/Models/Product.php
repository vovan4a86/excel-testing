<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;
use Carbon\Carbon;

/**
 * Fanky\Admin\Models\Product
 *
 * @property int                                                                              $id
 * @property int                                                                              $catalog_id
 * @property string                                                                           $name
 * @property string|null                                                                      $text
 * @property float                                                                            $price
 * @property float                                                                            $price_unit
 * @property string                                                                           $unit
 * @property string                                                                           $image
 * @property int                                                                              $published
 * @property int                                                                              $on_main
 * @property int                                                                              $order
 * @property string                                                                           $alias
 * @property string                                                                           $title
 * @property string                                                                           $keywords
 * @property string                                                                           $description
 * @property \Carbon\Carbon|null                                                              $created_at
 * @property \Carbon\Carbon|null                                                              $updated_at
 * @property string|null                                                                      $deleted_at
 * @property-read \Fanky\Admin\Models\Catalog                                                 $catalog
 * @property-read mixed                                                                       $image_src
 * @property-read mixed                                                                       $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\ProductImage[] $images
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product onMain()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product public ()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereCatalogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereOnMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product wherePriceUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Product withoutTrashed()
 * @mixin \Eloquent
 * @property string|null                                                                      $size
 * @property string|null                                                                      $h1
 * @property string|null                                                                      $price_name
 * @property string|null                                                                      $og_title
 * @property string|null                                                                      $warehouse
 * @property string|null                                                                      $wall
 * @property string|null                                                                      $characteristic
 * @property string|null                                                                      $characteristic2
 * @property string|null                                                                      $cutting
 * @property string|null                                                                      $steel
 * @property string|null                                                                      $length
 * @property string|null                                                                      $gost
 * @property string|null                                                                      $comment
 * @property float|null                                                                       $weight
 * @property float|null                                                                       $balance
 * @property string|null                                                                      $og_description
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereCharacteristic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereCharacteristic2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereCutting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereGost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product wherePriceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereSteel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereWall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereWarehouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Product whereWeight($value)
 */
class Product extends Model {

	protected $_parents = [];

//	protected $fillable = ['catalog_id', 'name', 'text', 'price', 'image', 'alias', 'title', 'keywords', 'description', 'order', 'published'];
	protected $guarded = ['id'];

	const UPLOAD_PATH = '/public/uploads/products/';
	const UPLOAD_URL = '/uploads/products/';

	public static $thumbs = [
		1 => '210x243',
	];

	public function catalog() {
		return $this->belongsTo(Catalog::class);
	}

	public function images() {
		return $this->hasMany(ProductImage::class, 'product_id');
	}

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function scopeOnMain($query) {
		return $query->where('on_main', 1);
	}

	public function getImageAttribute() {
		if ($image = $this->images()->orderBy('order')->first()) {
			return $image;
		} else {
			return null;
		}
	}

	public function getImageSrcAttribute($value) {
		$image = $this->getImageAttribute();

		return ($image) ? $image->src : null;
	}

	public function thumb($thumb) {
		$image = $this->getImageAttribute();

		return ($image) ? $image->thumb($thumb) : null;
	}
	private $_url;
	public function getUrlAttribute($value) {
		if(!$this->_url){
			$this->_url = $this->catalog->url . '/' . $this->alias;
		}
		return $this->_url;
	}

	public function getParents($with_self = false, $reverse = false) {
		$parents = [];
		if ($with_self) $parents[] = $this;
		$parents = array_merge($parents, $this->catalog->getParents(true));
		$parents = array_merge($parents, $this->_parents);
		if ($reverse) {
			$parents = array_reverse($parents);
		}

		return $parents;
	}

	public function delete() {
		foreach ($this->images as $image) {
			$image->delete();
		}

		parent::delete();
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}

	public function getBread() {
		$bread = $this->catalog->getBread();
		$bread[] = [
			'url'  => $this->url,
			'name' => $this->name
		];

		return $bread;
	}
}
