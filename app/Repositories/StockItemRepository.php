<?php

	namespace App\Repositories;

	use App\Imports\StockItemsImport;
	use App\Repositories\Interfaces\PageRepositoryInterface;
	use App\Repositories\Interfaces\StockRepositoryInterface;
	use Carbon\Carbon;
	use DB;
	use Fanky\Admin\Models\Stock;
	use Fanky\Admin\Models\StockItem;
	use Maatwebsite\Excel\Facades\Excel;
	use Phpexcelreader\Phpexcelreader\Spreadsheet_Excel_Reader;
	use Text;

	class StockItemRepository implements Interfaces\StockItemRepositoryInterface {

		public function parseXLS(Spreadsheet_Excel_Reader $reader, Stock $stock) {
			$startParse = Carbon::now();
			for ($i = 3; $i <= $reader->sheets[0]['numRows']; $i++) {
				$row = array_get($reader->sheets[0]['cells'], $i, []);
				$price_name = $name = array_get($row, 2);
				$steel = array_get($row, 3);
				$weight = array_get($row, 4);
				$gost = array_get($row, 5);
				$reserved = array_get($row, 6);
				if (!$name || !$steel) continue;
				$data = compact('name', 'price_name', 'steel', 'weight', 'gost', 'reserved');
				$data['in_stock'] = 1;
				$data['published'] = 1;
				$data['updated_at'] = Carbon::now();
            if(!$item = $this->getItemByPriceName($name, $steel, $stock)) {
				$this->createItem($data, $stock);
				} else {
						$item->update($data);
				}
			}

			$stock->stockItems()
				->where('updated_at', '<', $startParse)
				->update([
					'in_stock' => 0
				]);
		}

		public function getItemByPriceName($name, $steel, Stock $stock): ?StockItem {
			return $stock->stockItems()
				->where('price_name', $name)
				->where('steel', $steel)
				->first();
		}

		public function createItem($data, Stock $stock): StockItem {
			if (!array_get($data, 'alias')) {
				$data['alias'] = Text::translit($data['name'] . '-' . $data['steel']);
			}
			if (!array_get($data, 'title')) {
				$data['title'] = $data['name'] . '-' . $data['steel'];
			}
			$data['order'] = $stock->stockItems()->max('order') + 1;

			return $stock->stockItems()->create($data);
		}

		public function getInStockItems(Stock $stock) {
			return $stock->stockItems()
				->public()
				->inStock()
				->orderBy('order')
				->get();
		}

		public function getItem(Stock $stock, $id) {
			return $stock->stockItems()
				->public()
				->where('id', $id)
				->first();
		}

		public function getBread(StockItem $stockItem) {
			$stockRepository = app(StockRepositoryInterface::class);
			$stock = $stockRepository->getById($stockItem->stock_id);
			$bread = $stockRepository->getBread($stock);
			$bread[] = [
				'name' => $stockItem->name,
				'url' => $this->getUrl($stockItem, $stock)
			];

			return $bread;
		}

		public function getRelated(StockItem $stockItem) {
			return StockItem::query()
				->public()
				->inStock()
				->where('steel', $stockItem->steel)
				->where('gost', $stockItem->gost)
				->limit(10)
				->get();
		}

		public function getUrl(StockItem $stockItem, Stock $stock = null) {
			if (!$stock) {
				$stock = app(StockRepositoryInterface::class)->getById($stockItem->stock_id);
			}

			return route('stocks.item', [
				$stock->alias,
				$stockItem->id
			]);
		}
	}
