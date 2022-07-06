<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;

interface NewsRepositoryInterface {
    public function getByAlias($alias): ?News;

    public function getBread(News $news);

    public function getLast($limit = 5);

    public function getArchiveYears();

    public function getAllWithPaginate($perPage): LengthAwarePaginator;

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator;
}