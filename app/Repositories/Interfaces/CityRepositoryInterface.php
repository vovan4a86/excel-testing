<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CityRepositoryInterface {
    public function getById($id, $allowCached = true);

    public function getByAlias(string $alias, $allowCached = true);

    public function current($city_alias = null, $remember = true, Request $request = null);
}