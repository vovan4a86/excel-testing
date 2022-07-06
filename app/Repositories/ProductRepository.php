<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CatalogRepositoryInterface;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements Interfaces\ProductRepositoryInterface {

    public function getOnMain() {
        return Product::whereOnMain(1)
            ->with(['catalog', 'image'])
            ->orderBy('order')
            ->get();
    }

    public function getOnSpec() {
        return Product::orderBy('order')
            ->with(['catalog','image'])
            ->public()
            ->whereOnSpec(1)->get();
    }

    public function getUrlById(int $id){
        // TODO: Implement getUrlById() method.
    }

    public function getByAlias(string $alias, Catalog $parent): ?Product{
        return $parent->public_products()
            ->where('alias', $alias)
            ->first();
    }

    public function getUrl(Product $product): string {
        $catalogUrl = app(CatalogRepositoryInterface::class)->getUrlById($product->catalog_id);
        return $catalogUrl . '/' . $product->alias;
    }

    public function getParents(Product $product, $with_self = false, $reverse = false){
        $parent = $product->catalog;
        $parents = $with_self ? [$product]: [];
        if(!$parent) return $parents;
        $parents = array_merge(
            $parents,
            app(CatalogRepositoryInterface::class)->getParents($parent, true));

        return !$reverse
            ? $parents
            : array_reverse($parents);
    }

    public function getRelated(Product $product): Collection {
        return $product
            ->related()
            ->public()
            ->with(['catalog', 'image'])
            ->get();
    }

    public function getParams(Product $product): Collection {
        return $product
            ->params()
            ->orderBy('order')
            ->get();
    }
}