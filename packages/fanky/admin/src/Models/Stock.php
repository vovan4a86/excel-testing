<?php namespace Fanky\Admin\Models;

use App\Imports\StockItemsImport;
use App\Repositories\Interfaces\StockItemRepositoryInterface;
use App\Repositories\Interfaces\StockRepositoryInterface;
use App\Traits\HasH1;
use App\Traits\HasSEO;
use Carbon\Carbon;
use Debugbar;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spreadsheet_Excel_Reader as Reader;

class Stock extends Model {
    use HasH1, HasSEO;
	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/stocks/';
	protected $casts = [
		'data'	=> 'array'
	];

	public function scopePublic($query) {
		return $query->wherePublished(1);
	}

    /** Ззаглушка для левого меню */
    public function getPublicChildrenAttribute() {
        return collect();
    }

    /** Ззаглушка для левого меню */
    public function getPublicChildrenOnMenuAttribute() {
        return collect();
    }

    public function stockItems() {
        return $this->hasMany(StockItem::class)
            ->orderBy('order');
    }

	public function importXLS(UploadedFile $file) {
		$filename = $this->generatePriceName();
		$file->move(public_path(self::UPLOAD_URL), $filename);
		$filepath = public_path(self::UPLOAD_URL . $filename);
		if(!$list = $this->parseNewXLS($filepath)) return null;
		if($this->price) $this->removePrice();

		$this->price = $filename;
		$this->data = $list;

		$this->price_head = array_get($list, '1.2');
		$this->save();
	}

	public function parseXLS($filepath) {
		if(!File::exists($filepath)){
			Debugbar::error('Файл не найден: ' . $filepath);
			return null;
		}

		$reader = new Reader();
		$reader->setOutputEncoding('UTF-8');
		$reader->read($filepath);
		$data = $reader->sheets[0]['cells'];
        app(StockItemRepositoryInterface::class)->parseXLS($reader, $this);

		return $data;
	}

	public function removePrice() {
		@unlink(public_path(self::UPLOAD_URL . $this->price));
	}

	function generatePriceName(){
		return date("Ymd_Hms") . ".xls";
	}

	public function getPrice() {
		if(!$this->price) return null;

		return url(self::UPLOAD_URL . $this->price);
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}

	public function getUrlAttribute() {
		return app(StockRepositoryInterface::class)->getUrl($this);
	}

	public function getH1() {
		return $this->h1 ? $this->h1: $this->name;
	}

    public function getBread() {
        return app(StockRepositoryInterface::class)->getBread($this);
    }
}
