<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface {

    public function getOnMain();

    public function getOnSpec();

    public function getUrlById(int $id);

    public function getByAlias(string $alias, Catalog $parent);

    public function getUrl(Product $product);

    public function getParents(Product $product, $with_self = false, $reverse = false);

    public function getRelated(Product $product);

    public function getParams(Product $product): Collection;
}