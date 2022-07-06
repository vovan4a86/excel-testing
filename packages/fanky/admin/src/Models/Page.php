<?php namespace Fanky\Admin\Models;

use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Traits\HasH1;
use App\Traits\HasSEO;
use App\Traits\OgGenerate;
use Illuminate\Database\Eloquent\Model;
use URL;

class Page extends Model {
    use HasH1, OgGenerate, HasSEO;
    protected $table = 'pages';

    protected $parents = [];

    protected $guarded = ['id'];

    public static $excludeRegionAliases = [
        'contacts',
        'for_partners',
        'klientam',
        'alkado',
        'about',
        'news',
        'reviews',
        'about',
        'mechanisms',
        'pubs',
        'online_order',
        'dizayneri',
    ];

    public function parent() {
        return $this->belongsTo('Fanky\Admin\Models\Page', 'parent_id');
    }

    public function children() {
        return $this->hasMany('Fanky\Admin\Models\Page', 'parent_id');
    }

    public function public_children() {
        return $this->children()->public()->orderBy('order');
    }

    public function settingGroups() {
        return $this->hasMany('Fanky\Admin\Models\SettingGroup', 'page_id');
    }

    public function galleries() {
        return $this->hasMany('Fanky\Admin\Models\Gallery', 'page_id');
    }

    public function catalog() {
        return $this->hasOne('Fanky\Admin\Models\Catalog', 'page_id');
    }

    public function stock_items() {
        return $this->morphToMany(StockItem::class, 'stock_itemable');
    }

    public function stock_items_public() {
        return $this->stock_items()->public();
    }

    public function scopePublic($query) {
        return $query->where('published', 1);
    }

    public function scopeMain($query) {
        return $query->where('parent_id', 1);
    }

    public function scopeSubMenu($query) {
        return $query->where('parent_id', $this->id)->public()->orderBy('order');
    }
    private $_isRegion = null;
    public function getIsRegionAttribute(){
        return false;
//        if($this->_isRegion !== null) return $this->_isRegion;
//        if (!count($this->parents)) {
//            $this->getParents();
//        }
//        $path = [$this->alias];
//        foreach ($this->parents as $parent) {
//            $path[] = $parent->alias;
//        }
//        $path = array_reverse($path);
//        $root_alias = array_get($path, 0);
//        $this->_isRegion = !in_array($root_alias, self::$excludeRegionAliases);
//        return $this->_isRegion;
    }

    public function getBread() {
        $bread = [];
        foreach ($this->getParents(true) as $p) {
            $bread[] = [
                'url'  => $p->url,
                'name' => $p->name
            ];
        }

        return array_reverse($bread);
    }

    public function getViewName(): string {
        return view()->exists('pages.unique.' . $this->alias)
            ? 'pages.unique.' . $this->alias
            : 'pages.text';
    }

    public function getUrlAttribute() {
        return app(PageRepositoryInterface::class)->getUrl($this);
    }

    public function getIsActiveAttribute() {
        $url = URL::current();

        return ($url == $this->getUrlAttribute());
    }

    /**
     * @param $path
     *
     * @return Page
     */
    public static function getByPath($path): ?Page {
        return app(PageRepositoryInterface::class)->getByPath($path);
    }

    public function getParents($with_self = false, $reverse = false) {
        return app(PageRepositoryInterface::class)->getParents($this, $with_self, $reverse);
    }
}
