<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\StockItemRepositoryInterface;
use App\Repositories\Interfaces\StockRepositoryInterface;
use Fanky\Admin\Models\Page;

class StockController extends Controller {
    public function index() {
        $page = Page::getByPath(['sklad']);
        $page->setSeo();
        $stocks = app(StockRepositoryInterface::class)->getAll();

        return view('stock.index', [
            'h1'     => $page->getH1(),
            'text'   => $page->text,
            'bread'  => $page->getBread(),
            'stocks' => $stocks,
        ]);
    }

    public function stock($alias) {
        $stock = app(StockRepositoryInterface::class)->getbyAlias($alias);
        if(!$stock) abort('404');
        $stockItems = app(StockItemRepositoryInterface::class)->getInStockItems($stock);
        $stockItemsGrouped = $stockItems->groupBy('name')->all(); /* группировка товаров по имени */
        $stock->setSeo();
        $stocks = app(StockRepositoryInterface::class)->getAll();

        return view('stock.stock', [
            'stockItems' => $stockItemsGrouped,
            'stock'      => $stock,
            'h1'         => $stock->getH1(),
            'text'       => $stock->text,
            'bread'      => $stock->getBread(),
            'stocks'     => $stocks,
        ]);
    }

    public function stockItem($stockAlias, $stockItemId, StockItemRepositoryInterface $stockItemRepository) {
        $stock = app(StockRepositoryInterface::class)->getbyAlias($stockAlias);
        if(!$stock) abort('404');
        $stockItem = $stockItemRepository->getItem($stock, $stockItemId);
        $relatedItems = $stockItemRepository->getRelated($stockItem);
        $stockItem->setSeo();
        $stocks = app(StockRepositoryInterface::class)->getAll();

        return view('stock.item', [
            'relatedItems' => $relatedItems,
            'item'         => $stockItem,
            'stock'        => $stock,
            'h1'           => $stockItem->getH1(),
            'text'         => $stockItem->text,
            'bread'        => $stockItem->getBread(),
            'stocks'       => $stocks
        ]);
    }
}
