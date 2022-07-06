<?php

namespace App\Repositories;

use Fanky\Admin\Models\Catalog;
use Illuminate\Support\Collection;

class CatalogRepository implements Interfaces\CatalogRepositoryInterface {
    private $_listById = [], $_listByAlias = [], $_listByPath = [], $_urlById = [];

    public function getListById() {
        return $this->_listById;
    }
    public function getById($id, $allowCached = true) {
        if(!isset($this->_listById[$id]) || !$allowCached) {
            $catalog = Catalog::find($id);
            if($catalog){
                $this->_listById[$id] = $catalog;
                $this->_listByAlias[$catalog->alias] = $catalog;
            }
        }

        return array_get($this->_listById, $id, null);
    }

    public function getByAlias(string $alias, $allowCached = true) {
        if(!isset($this->_listByAlias[$alias]) || !$allowCached) {
            $catalog = Catalog::where('alias', $alias)->first();
            if($catalog){
                $this->_listByAlias[$alias] = $catalog;
                $this->_listById[$catalog->id] = $catalog;
            }
        }

        return array_get($this->_listByAlias, $alias, null);
    }

    public function getByPath($path, $allowCached = true) {
        $pathArray = is_array($path)
            ? $path
            : explode('/', trim($path, '/'));
        $path = implode('/', $pathArray);
        if(!isset($this->_listByPath[$path]) || !$allowCached) {
            $parent_id = 0;
            $catalog = null;

            /* проверка по пути */
            foreach($pathArray as $alias) {
                $catalog = Catalog::whereAlias($alias)
                    ->whereParentId($parent_id)
                    ->public()
                    ->first();

                if($catalog === null) {
                    break;
                }
                $this->_listById[$catalog->id] = $catalog;
                $this->_listByAlias[$catalog->alias] = $catalog;
                $parent_id = $catalog->id;
            }
            $this->_listByPath[$path] = $catalog && $catalog->id > 0
                ? $this->getById($catalog->id)
                : null;
        }

        return array_get($this->_listByPath, $path, null);
    }

    public function getUrlById(int $id) {
        $catalog = $this->getById($id);
        return $this->getUrl($catalog);
    }

    public function getParents(Catalog $catalog, $with_self = false, $reverse = false): array {
        $p = $catalog;
        $parents = $with_self ? [$p]: [];
        while ($p && $p->parent_id > 0) {
            $p = $this->getById($p->parent_id);
            $parents[] = $p;
        }
        if ($reverse) {
            $parents = array_reverse($parents);
        }

        return $parents;
    }

    public function getUrl(Catalog $catalog){
        if(!isset($this->_urlById[$catalog->id])){
            $path = [$catalog->alias];
            foreach ($this->getParents($catalog) as $parent) {
                $path[] = $parent->alias;
            }
            $path = implode('/', array_reverse($path));
            $path = route('catalog.view', ['alias' => $path], false);
            $city_alias = session('city_alias');
            if ($city_alias) {
                $path = '/' . $city_alias . $path;
            }
            $this->_urlById[$catalog->id] = url($path);
        }

        return array_get($this->_urlById, $catalog->id);
    }

    public function rememberCollection(Collection $catalogs) {
        foreach($catalogs as $catalog){
            $this->_listById[$catalog->id] = $catalog;
        }
    }

    private $_rootWithChildren = null;
    public function getRootWithChildren(){
        if(is_null($this->_rootWithChildren)){
            $this->_rootWithChildren = Catalog::whereParentId(0)
                ->with(['public_children'])
                ->orderBy('order')
                ->get();
            $this->rememberCollection($this->_rootWithChildren);
        }

        return $this->_rootWithChildren;
    }

    public function getLevel(Catalog $catalog): int{
        $parents = $this->getParents($catalog, true);

        return count($parents);
    }
}
