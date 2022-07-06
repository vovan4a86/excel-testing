<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Stock;
use Fanky\Admin\Models\StockItem;
use Phpexcelreader\Phpexcelreader\Spreadsheet_Excel_Reader;

interface StockItemRepositoryInterface {
    public function parseXLS(Spreadsheet_Excel_Reader $reader, Stock $stock);

    public function getItemByPriceName($name, $steel, Stock $stock): ?StockItem;

    public function createItem($data, Stock $stock): StockItem;

    public function getInStockItems(Stock $stock);

    public function getItem(Stock $stock, $id);

    public function getBread(StockItem $stockItem);

    public function getRelated(StockItem $stockItem);

    public function getUrl(StockItem $stockItem, Stock $stock = null);
}