<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PageRepositoryInterface;
use Fanky\Admin\Models\Publication;
use Fanky\Admin\Models\PublicationCategory;
use Fanky\Admin\Settings;
use Illuminate\Pagination\LengthAwarePaginator;

class PublicationsRepository implements Interfaces\PublicationsRepositoryInterface {

    public function getByAlias($alias): ?Publication{
        return Publication::whereAlias($alias)
            ->public()->first();
    }

    public function getBread(Publication $pubs){
        $page = app(PageRepositoryInterface::class)->getByPath(['publications']);
        $bread = $page->getBread();
        $bread[] = [
            'name' => $pubs->name,
            'url' => $pubs->url
        ];

        return $bread;
    }

    public function getLast($limit = 5) {
        return Publication::getLast(Settings::get('pubs_on_main', 5));
    }

    public function getAllWithPaginate($perPage): LengthAwarePaginator{
        return Publication::orderBy('date', 'desc')
            ->public()->paginate($perPage);
    }

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator{
        return Publication::orderBy('date', 'desc')
            ->year($year)
            ->public()->paginate($perPage);
    }

    public function getAllCategories() {
        return PublicationCategory::all();
    }
}
