<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Catalog;
use Illuminate\Support\Collection;

interface CatalogRepositoryInterface {
    public function getById($id, $allowCached = true);

    public function getByAlias(string $alias, $allowCached = true);

    public function getByPath($path, $allowCached = true);

    public function getUrlById(int $id);

    public function getParents(Catalog $catalog, $with_self = false, $reverse = false);

    public function getUrl(Catalog $catalog);

    public function rememberCollection(Collection $catalogs);

    public function getRootWithChildren();

    public function getLevel(Catalog $catalog): int;
}
