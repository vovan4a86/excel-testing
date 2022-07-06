<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Stock;

interface StockRepositoryInterface {
    public function getAll();

    public function getByAlias($alias);

    public function getBread(Stock $stock);

    public function getListById();

    public function getById($id, $allowCached = true);

    public function getUrlById(int $id);

    public function getUrl(Stock $stock);
}