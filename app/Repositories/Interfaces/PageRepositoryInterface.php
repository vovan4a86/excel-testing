<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface PageRepositoryInterface {
    public function getById($id, $allowCached = true);

    public function getByAlias(string $alias, $allowCached = true);

    public function getByPath($path, $allowCached = true): ?Page;

    public function getUrlById(int $id);

    public function getParents(Page $catalog, $with_self = false, $reverse = false);

    public function getUrl(Page $page);

    public function rememberCollection(Collection $pages);

    public function getMainMenu();

    public function getAboutMenu();
}