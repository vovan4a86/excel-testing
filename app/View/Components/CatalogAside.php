<?php

namespace App\View\Components;

use App\Repositories\Interfaces\CatalogRepositoryInterface;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\PublicationCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CatalogAside extends Component {
    public $catalogs;
    public function __construct(CatalogRepositoryInterface $repository, Collection $items = null) {
        $this->catalogs = !is_null($items) && $items->count()
            ? $items
            : $repository->getRootWithChildren();
    }

    public function render() {
        return view('components.catalog-aside');
    }
}
