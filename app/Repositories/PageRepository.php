<?php

namespace App\Repositories;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Page;
use Illuminate\Support\Collection;

class PageRepository implements Interfaces\PageRepositoryInterface {
    private $_listById = [], $_listByAlias = [], $_urlById = [];
    public function getById($id, $allowCached = true) {
        if(!isset($this->_listById[$id]) || !$allowCached) {
            $page = Page::find($id);
            if($page){
                $this->_listById[$id] = $page;
                $this->_listByAlias[$page->alias] = $page;
            }
        }

        return array_get($this->_listById, $id, null);
    }

    public function getByAlias(string $alias, $allowCached = true) {
        if(!isset($this->_listByAlias[$alias]) || !$allowCached) {
            $page = Page::where('alias', $alias)->first();
            if($page){
                $this->_listByAlias[$alias] = $page;
                $this->_listById[$page->id] = $page;
            }
        }

        return array_get($this->_listByAlias, $alias, null);
    }

    public function getByPath($path, $allowCached = true): ?Page{
        $pathArray = is_array($path)
            ? $path
            : explode('/', trim($path, '/'));
        $path = implode('/', $pathArray);
        if(!isset($this->_listByPath[$path]) || !$allowCached) {
            $parent_id = 1;
            $catalog = null;

            /* проверка по пути */
            foreach($pathArray as $alias) {
                $catalog = Page::whereAlias($alias)
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

    public function getUrlById(int $id){
        $catalog = $this->getById($id);
        return $this->getUrl($catalog);
    }

    public function getParents(Page $catalog, $with_self = false, $reverse = false): array {
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

    public function getUrl(Page $page){
        if(!isset($this->_urlById[$page->id])){
            $path = [$page->alias];
            foreach ($this->getParents($page) as $parent) {
                $path[] = $parent->alias;
            }
            $path = implode('/', array_reverse($path));
            $path = route('default', ['alias' => $path], false);
            $city_alias = session('city_alias');
            if ($city_alias && $page->isRegion) {
                $path = '/' . $city_alias . $path;
            }
            $this->_urlById[$page->id] = url($path);
        }
        return $this->_urlById[$page->id];
    }

    public function rememberCollection(Collection $pages) {
        foreach($pages as $page){
            $this->_listById[$page->id] = $page;
        }
    }

    private $_mainMenu = null;
    public function getMainMenu(){
        if(is_null($this->_mainMenu)){
            $this->_mainMenu = Page::whereParentId(1)
                ->where('on_menu', 1)
                ->orderBy('order')
                ->public()->get();
        }

        return $this->_mainMenu;
    }

    private $_aboutMenu = null;
    public function getAboutMenu(){
        if(is_null($this->_aboutMenu)){
            $this->_aboutMenu = Page::query()
                ->public()
                ->whereIn('id', [
                    32, //news
                    33, //sobytiya
                ])->orderBy('order')
                ->get();
        }

        return $this->_aboutMenu;
    }
}
