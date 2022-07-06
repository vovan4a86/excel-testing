<?php

namespace App\Repositories\Interfaces;

use Fanky\Admin\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

interface EventRepositoryInterface {
    public function getByAlias($alias): ?Event;

    public function getBread(Event $news);

    public function getLast($limit = 5);

    public function getArchiveYears();

    public function getAllWithPaginate($perPage): LengthAwarePaginator;

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator;
}