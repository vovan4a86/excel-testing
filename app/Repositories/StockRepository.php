<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PageRepositoryInterface;
use Fanky\Admin\Models\Stock;
use Fanky\Admin\Models\StockItem;

class StockRepository implements Interfaces\StockRepositoryInterface {
    private $_listById = [], $_listByAlias = [], $_listByPath = [], $_urlById = [];
    public function getAll() {
        return Stock::orderBy('order')
            ->public()
            ->get();
    }

    public function getByAlias($alias){
        if(!isset($this->_listByAlias[$alias])) {
            $stock = Stock::query()
                ->where('alias', $alias)
                ->public()
                ->first();
            if($stock){
                $this->_listByAlias[$alias] = $stock;
                $this->_listById[$stock->id] = $stock;
            }
        }

        return array_get($this->_listByAlias, $alias, null);
    }

    public function getBread(Stock $stock){
        $page = app(PageRepositoryInterface::class)->getByAlias('sklad');
        $bread = $page->getBread();
        $bread[] = [
            'name' => $stock->name,
            'url' => $stock->url,
        ];

        return $bread;
    }

    public function getListById() {
        return $this->_listById;
    }

    public function getById($id, $allowCached = true) {
        if(!isset($this->_listById[$id]) || !$allowCached) {
            $catalog = Stock::find($id);
            if($catalog){
                $this->_listById[$id] = $catalog;
                $this->_listByAlias[$catalog->alias] = $catalog;
            }
        }

        return array_get($this->_listById, $id, null);
    }

    public function getUrlById(int $id) {
        $stock = $this->getById($id);
        return $this->getUrl($stock);
    }

    public function getUrl(Stock $stock){
        return route('stocks.stock', [$stock->alias]);
    }
}
