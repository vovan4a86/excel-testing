<?php namespace Fanky\Admin\Controllers;

use App\Imports\StockItemsImport;
use App\Repositories\Interfaces\StockItemRepositoryInterface;
use Fanky\Admin\Models\StockItem;
use Fanky\Admin\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

//use Request;
use Validator;
use Text;
use DB;

class AdminStockController extends AdminController {

	public function getIndex() {
		$catalogs = Stock::orderBy('order')->get();

		return view('admin::stock.main', ['catalogs' => $catalogs]);
	}

	public function parse(Request $request) {
		$stockId = $request->get('id');
		$priceFile = $request->file('fileXls');
		$data = $request->except(['id']);

		// валидация данных
		$validator = Validator::make($data,	[
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$redirect = false;
		/** @var Stock $catalog */
		$catalog = Stock::find($stockId);

		$filename = $catalog->generatePriceName();
//		$priceFile->storeAs(public_path(Stock::UPLOAD_URL), $filename);
//		$priceFile->move(public_path(Stock::UPLOAD_URL), $filename);
//		$filepath = public_path(Stock::UPLOAD_URL . $filename);

		dd($priceFile);
		if ($filename) {
			Excel::import(new StockItemsImport($stockId), $priceFile);
		}

//		if(!$list = $this->parseNewXLS($filepath)) return null;
		if($catalog->price) $catalog->removePrice();
		$catalog->price = $filename;
//		$this->data = $list;

//		$this->price_head = array_get($list, '1.2');
//		$catalog->price_head = 'Склад N3';
//			$data['price_head'] = 'Склад N3';
//		$catalog->save();


		if (!$catalog) {
			if (!$data['alias']) $data['alias'] = Text::translit($data['name']);
			if (!$data['title']) $data['title'] = $data['name'];
			$data['order'] = Stock::query()->max('order') + 1;
			$catalog = Stock::create($data);
			$redirect = true;
		} else {
			$catalog->update($data);
		}

		return $redirect
			? ['redirect' => route('admin.stock.catalogEdit', [$catalog->id])]
			: ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postProducts($catalog_id) {
		$catalog = Stock::findOrFail($catalog_id);
		$products = $catalog->stockItems;

		return view('admin::stock.products', [
			'catalog' => $catalog,
			'products' => $products
		]);
	}

	public function getProducts($catalog_id) {
		$catalogs = Stock::orderBy('order')->get();

		return view('admin::stock.main', [
			'catalogs' => $catalogs,
			'content' => $this->postProducts($catalog_id)]);
	}

	public function postCatalogEdit($id = null) {
		if (!$id || !($catalog = Stock::findOrFail($id))) {
			$catalog = new Stock([
				'published' => 1,
			]);
		}
		$catalogs = Stock::orderBy('order')->get(['id', 'name']);

		return view('admin::stock.catalog_edit', [
			'catalog' => $catalog, 'catalogs' => $catalogs
		]);
	}

	public function getCatalogEdit($id = null) {
		$catalogs = Stock::orderBy('order')->get();

		return view('admin::stock.main', ['catalogs' => $catalogs, 'content' => $this->postCatalogEdit($id)]);
	}

	public function postCatalogSave() {
		$id = Request::get('id');
		$data = Request::except(['id']);
		$priceFile = Request::file('fileXls');

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}
		// сохраняем страницу
		$redirect = false;
		/** @var Stock $catalog */
		$catalog = Stock::find($id);
		if (!$catalog) {
			if (!$data['alias']) $data['alias'] = Text::translit($data['name']);
			if (!$data['title']) $data['title'] = $data['name'];
			$data['order'] = Stock::query()->max('order') + 1;
			$catalog = Stock::create($data);
			$redirect = true;
		} else {
			$catalog->update($data);
		}

		if ($priceFile) {
			$catalog->importXLS($priceFile);
		}

		return $redirect
			? ['redirect' => route('admin.stock.catalogEdit', [$catalog->id])]
			: ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postCatalogReorder() {
		// сортировка
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('catalogs')->where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postCatalogDelete($id) {
		$catalog = Stock::findOrFail($id);
		$catalog->delete();

		return ['success' => true];
	}

	public function postProductEdit($id = null) {
		if (!$id || !($product = StockItem::findOrFail($id))) {
			$product = new StockItem([
				'stock_id' => Request::get('catalog')
			]);
		}
		return view('admin::stock.product_edit', [
			'product' => $product,
			'stocks' => Stock::orderBy('order')->pluck('name', 'id')
		]);
	}

	public function getProductEdit($id = null) {
		$catalogs = Stock::orderBy('order')->get();

		return view('admin::stock.main', ['catalogs' => $catalogs, 'content' => $this->postProductEdit($id)]);
	}


	public function postProductSave() {
		$id = Request::get('id');
		$data = Request::except(['id']);
		$data = array_map('trim', $data);
		$image = Request::file('image');
		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
				'stock_id' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}
		if ($image) {
			$data['image'] = StockItem::uploadImage($image);
		}
		// сохраняем страницу
		$product = StockItem::find($id);
		$stock = Stock::find($data['stock_id']);
		if (!$data['alias']) $data['alias'] = Text::translit($data['name'] . '-' . $data['steel']);
		if (!$data['title']) $data['title'] = $data['name'];
		if (!$product) {
			$product = app(StockItemRepositoryInterface::class)->createItem($data, $stock);
			$check_alias = StockItem::query()
				->where('alias', $product->alias)
				->where('id', '!=', $product->id)
				->first();
			if ($check_alias) {
				$product->update([
					'alias' => $product->id . '-' . $product->alias
				]);
			}
			return ['redirect' => route('admin.stock.productEdit', [$product->id])];
		} else {
			$product->update($data);
		}

		return ['success' => true, 'msg' => 'Изменения с`охранены'];
	}

	public function postProductReorder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			StockItem::where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postProductDelete($id) {
		$product = StockItem::findOrFail($id);
		$product->delete();

		return ['success' => true];
	}

	public function postTree() {
		$stocks = Stock::query()->orderBy('order')->get();
		$tree = [];
		foreach ($stocks as $stock) {
			$tree[] = [
				'text' => $stock->name,
				'selectable' => false,
				'expanded' => true,
				'value' => 'stock_' . $stock->id,
				'type' => 'stock',
				'nodes' => $this->stockTreeItems($stock),
				'state' => array('expanded' => false),
			];
		}

		return ['tree' => $tree];
	}

	private function stockTreeItems(Stock $stock) {
		$nodes = [];
		foreach ($stock->stockItems as $stockItem) {
			$nodes[] = [
				'text' => "$stockItem->name ($stockItem->steel, $stockItem->gost)",
				'selectable' => true,
				'expanded' => false,
				'value' => $stockItem->id,
				'type' => 'stock_item',
				'state' => array('expanded' => false),
			];
		}

		return $nodes;
	}
}
