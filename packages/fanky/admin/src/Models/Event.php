<?php namespace Fanky\Admin\Models;

use App\Traits\HasH1;
use App\Traits\HasImage;
use App\Traits\HasSEO;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SiteHelper;
use Thumb;
use Carbon\Carbon;

/**
 * Fanky\Admin\Models\Event
 *
 * @property int                 $id
 * @property int                 $published
 * @property string|null         $date
 * @property string              $name
 * @property string|null         $announce
 * @property string|null         $text
 * @property string              $image
 * @property string              $alias
 * @property string              $title
 * @property string              $keywords
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @property-read mixed          $image_src
 * @property-read mixed          $url
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News public ()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereAnnounce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\News withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\News withoutTrashed()
 * @mixin \Eloquent
 * @property string $h1
 * @property string|null $og_title
 * @property string|null $og_description
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\NewsTag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\News whereOgTitle($value)
 */
class Event extends Model {

	use HasImage, HasSEO, HasH1;

	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/events/';

	public static $thumbs = [
		1 => '100x50', //admin
		2 => '300x190|fit', //news_list
	];

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

    public function scopeYear($query, $year) {
        return $query->where(DB::raw('YEAR(date)'), $year);
    }

	public function getUrlAttribute($value) {
		return route('event.item', ['name' => $this->alias]);
	}

	public function dateFormat($format = 'd.m.Y') {
		if (!$this->date) return null;
		$date =  date($format, strtotime($this->date));
        return str_replace(array_keys(SiteHelper::getMonthRu()),
			SiteHelper::getMonthRu(), $date);
	}

	public static function last($count = 2) {
		$items = self::orderBy('date', 'desc')->public()->limit($count)->get();

		return $items;
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}
}
