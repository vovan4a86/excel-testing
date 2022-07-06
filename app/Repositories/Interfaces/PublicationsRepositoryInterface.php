<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Publication;
use Illuminate\Pagination\LengthAwarePaginator;

interface PublicationsRepositoryInterface {
    public function getByAlias($alias): ?Publication;

    public function getBread(Publication $pubs);

    public function getLast($limit = 5);

    public function getAllWithPaginate($perPage): LengthAwarePaginator;

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator;

    public function getAllCategories();
}
