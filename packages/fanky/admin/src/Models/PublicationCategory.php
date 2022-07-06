<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;


/**
 * Fanky\Admin\Models\PublicationTag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Publication[] $publications
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\PublicationCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\PublicationCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\PublicationCategory query()
 * @mixin \Eloquent
 */
class PublicationCategory extends Model {

	protected $guarded = ['id'];

    protected $table = 'publication_categories';

    public function publications() {
		return $this->hasMany(Publication::class, 'category_id');
	}
}
