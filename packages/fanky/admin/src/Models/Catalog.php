<?php namespace Fanky\Admin\Models;

use App\Repositories\Interfaces\CatalogRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\ProductRepository;
use SiteHelper;
use App\Traits\HasCanonical;
use App\Traits\HasH1;
use App\Traits\HasImage;
use App\Traits\HasSEO;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use URL;

/**
 * Fanky\Admin\Models\Catalog
 * @mixin Eloquent
 * @property mixed $parent_id
 */
class Catalog extends Model {
    use HasImage, HasH1, HasCanonical, HasSEO;
    protected $table = 'catalogs';
    protected $parents = [];
    protected $fillable = ['parent_id', 'name', 'h1', 'text', 'text_prev',
                           'status', 'content_tech', 'content_gosti',
                           'text_after', 'alias', 'title', 'keywords',
                           'description', 'order', 'published', 'hide_on_menu',
                           'on_main', 'image', 'lvl', 'on_catalog',
                           'product_title_template', 'product_description_template'
    ];

    const UPLOAD_URL = '/uploads/catalog/';

    public static $thumbs = [
        1 => '156x110',
        2 => '451x302',
    ];

    public function parent() {
        return $this->belongsTo('Fanky\Admin\Models\Catalog', 'parent_id');
    }

    public function children() {
        return $this->hasMany('Fanky\Admin\Models\Catalog', 'parent_id');
    }

    public function public_children() {
        return $this->children()->public()->orderBy('order');
    }

    public function public_children_on_main() {
        return $this->public_children()->where('on_main', 1);
    }

    public function public_children_on_menu() {
        return $this->public_children()->where('hide_on_menu', 0);
    }

    public function stock_items() {
        return $this->morphToMany(StockItem::class, 'stock_itemable');
    }

    public function stock_items_public() {
        return $this->stock_items()->public();
    }

    public function products() {
        return $this->hasMany(Product::class, 'catalog_id');
    }

    public function siblings() {
        return self::where('parent_id', $this->parent_id);
    }

    public function public_siblings() {
        return $this->siblings()->public()->orderBy('order');
    }

    public function public_products() {
        return $this->products()->public();
    }

    public function addtional_products() {
        return $this->belongsToMany(Product::class);
    }

    public function scopePublic($query) {
        return $query->where('published', 1);
    }

    public function scopeOnMain($query) {
        return $query->where('on_main', 1);
    }

    public function scopeOnMenu($query) {
        return $query->where('hide_on_menu', 0);
    }

    public function scopeMainMenu($query) {
        return $query->public()->where('parent_id', 0)->orderBy('order');
    }

    public function getUrlAttribute() {
        return app(CatalogRepositoryInterface::class)->getUrl($this);
    }

    public function getIsActiveAttribute() {
        $url = URL::current();

        return ($url == $this->getUrlAttribute());
    }

    public function getBread(): array {
        $catalogPage = app(PageRepositoryInterface::class)->getByAlias('catalog');
        $bread = [[
                      'url'  => $catalogPage->url,
                      'name' => $catalogPage->name
                  ]];
        $parents = app(CatalogRepositoryInterface::class)->getParents($this, true, true);

        foreach ($parents as $parent) {
            $bread[] = [
                'url'  => $parent->url,
                'name' => $parent->name
            ];
        }
        return $bread;
    }


    public static function getChildrenRecurse($catalog_id) {
        $result = [$catalog_id];
        $c = Catalog::whereParentId($catalog_id)->get();
        if ($c) {
            foreach ($c as $i) {
                $result = array_merge($result, self::getChildrenRecurse($i->id));
            }
        }

        return $result;
    }

    public function getRootParent() {
        $parents =  app(CatalogRepositoryInterface::class)->getParents($this,false, true);

        return array_get($parents,0, null);
    }

    public function delete() {
        foreach ($this->products as $product) {
            $product->delete();
        }

        parent::delete();
    }
}
