<?php namespace Fanky\Admin\Models;

use App\Repositories\Interfaces\StockItemRepositoryInterface;
use App\Traits\HasH1;
use App\Traits\HasImage;
use App\Traits\HasSEO;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 */
class StockItem extends Model {
    use HasH1, HasSEO, HasImage;
	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/stock_items/';

	public static $thumbs = [
		1 => '150x150', //admin
		2 => '450x', //product_page
	];

    public function scopePublic($query) {
        $query->where('published', 1);
    }

    public function scopeInStock($query) {
        return $query->whereInStock(1);
    }

	public function stock() {
		return $this->belongsTo(Stock::class);
	}

    public function getUrlAttribute() {
        return app(StockItemRepositoryInterface::class)->getUrl($this);
    }

    public function getBread() {
        return app(StockItemRepositoryInterface::class)->getBread($this);
    }
}
