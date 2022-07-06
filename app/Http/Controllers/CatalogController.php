<?php namespace App\Http\Controllers;

use App\Repositories\Interfaces\CatalogRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\MaterialImage;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\PublicationCategory;
use SEOMeta;
use View;
use Request;

class CatalogController extends Controller {
    protected $catalogRepository, $pageRepository, $productRepository;

    public function __construct(CityRepositoryInterface    $cityRepository,
                                CatalogRepositoryInterface $catalogRepository,
                                ProductRepositoryInterface $productRepository,
                                PageRepositoryInterface    $pageRepository) {
        $this->catalogRepository = $catalogRepository;
        $this->productRepository = $productRepository;
        $this->pageRepository = $pageRepository;
    }

    public function index() {
        $page = $this->pageRepository->getByPath(['catalog']);
        if(!$page) return abort(404);
        $page->setSeo();
        $catalogs = $this->catalogRepository->getRootWithChildren();

        return view('catalog.index', [
            'bread'    => $page->getBread(),
            'h1'       => $page->getH1(),
            'text'     => $page->text,
            'catalogs' => $catalogs,
        ]);
    }

    public function view($alias) {
        $path = explode('/', $alias);
        /* проверка на продукт в категории */
        if($category = $this->catalogRepository->getByPath($path)) {
            return $this->category($category);
        } else {
            abort(404);
        }
//        $product = null;
//        $end = array_pop($path);
//        $category = $this->catalogRepository->getByPath($path);
//        if($category && $category->published) {
//            $product = $this->productRepository->getByAlias($end, $category);
//        }
//        if($product) {
//            return $this->product($product);
//        } else {
//            $path[] = $end;
//            if($category = $this->catalogRepository->getByPath($path)) {
//                return $this->category($category);
//            } else {
//                abort(404);
//            }
//        }
    }

    public function category(Catalog $category) {
        $bread = $category->getBread();
        View::share('bread', $bread);
        $level  = $this->catalogRepository->getLevel($category);
        $children = [];
        if($level == 2){
            $children = $category->public_children;
        }
        if($level == 3){
            $children = $category->public_siblings()->get();
        }

        $category->setSeo();
        $view = !$category->parent_id
            ? 'catalog.root_category'
            : 'catalog.category';
        $stockItems = $category->stock_items_public;
        $leftMenuItems = $this->catalogRepository->getRootWithChildren();

        return view($view, [
            'stockItems'    => $stockItems,
            'category'      => $category,
            'children'      => $children,
            'h1'            => $category->getH1(),
            'leftMenuItems' => $leftMenuItems,
        ]);
    }

    public function product(Product $product) {
        if(Request::ajax()) {
            return view('catalog.product_fastview', [
                'product' => $product
            ]);
        }
        $bread = $product->getBread();
        View::share('bread', $bread);
//		$related = $product->related()->public()->with('catalog')->get();
        SEOMeta::setTitle($product->title);
        SEOMeta::setDescription($product->description);
        SEOMeta::setKeywords($product->keywords);

        return view('catalog.product', [
            'product' => $product,
            //			'related'     => $related,
            'name'    => $product->name,
        ]);
    }
}
