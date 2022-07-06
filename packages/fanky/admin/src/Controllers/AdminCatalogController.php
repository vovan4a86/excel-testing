<?php namespace Fanky\Admin\Controllers;

use Request;
use Settings;
use Validator;
use Text;
use DB;
use Image;
use Thumb;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductImage;

class AdminCatalogController extends AdminController {

	public function getIndex() {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs]);
	}

	public function postProducts($catalog_id) {
		$catalog = Catalog::findOrFail($catalog_id);
		$products = $catalog->products()->orderBy('order')->get();

		return view('admin::catalog.products', ['catalog' => $catalog, 'products' => $products]);
	}

	public function getProducts($catalog_id) {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProducts($catalog_id)]);
	}

	public function postCatalogEdit($id = null) {
		if (!$id || !($catalog = Catalog::findOrFail($id))) {
			$catalog = new Catalog;
			$catalog->parent_id = Request::input('parent');
			$catalog->published = 1;
		}
		$catalogs = Catalog::orderBy('order')->where('id', '!=', $catalog->id)->get();

		return view('admin::catalog.catalog_edit', [
            'catalog' => $catalog, 'catalogs' => $catalogs,
            'stockItemIds' => $catalog->stock_items()->pluck('id')->all()
        ]);
	}

	public function getCatalogEdit($id = null) {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', [
            'catalogs' => $catalogs,
            'content' => $this->postCatalogEdit($id)
        ]);
	}

	public function postCatalogSave() {
		$id = Request::input('id');
		$data = Request::except(['id', 'stock_items', 'image']);
        $image = Request::file('image');
        $stockItemIds = Request::get('stock_items', []);
		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$catalog = Catalog::find($id);
        $redirect = false;
        if($image){
            $data['image'] = Catalog::uploadImage($image);
        }
		if (!$catalog) {
			$data['order'] = Catalog::where('parent_id', $data['parent_id'])->max('order') + 1;
			$catalog = Catalog::create($data);

			$redirect = true;
		} else {
			$catalog->update($data);
		}
        $catalog->stock_items()->sync($stockItemIds);

        return $redirect
            ? ['redirect' => route('admin.catalog.catalogEdit', [$catalog->id])]
            : ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postCatalogReorder() {
		// изменеие родителя
		$id = Request::input('id');
		$parent = Request::input('parent');
		DB::table('catalogs')->where('id', $id)->update(array('parent_id' => $parent));
		// сортировка
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('catalogs')->where('id', $id)->update(array('order' => $order));
		}

		return ['success' => true];
	}

	public function postCatalogDelete($id) {
		$catalog = Catalog::findOrFail($id);
		$catalog->delete();

		return ['success' => true];
	}

	public function postProductEdit($id = null) {
		if (!$id || !($product = Product::findOrFail($id))) {
			$product = new Product;
			$product->catalog_id = Request::input('catalog');
			$product->published = 1;
		}
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.product_edit', ['product' => $product, 'catalogs' => $catalogs]);
	}

	public function getProductEdit($id = null) {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProductEdit($id)]);
	}

	public function postProductSave() {
		$id = Request::input('id');
		$data = Request::except(['id']);
		if (!array_get($data, 'published')) $data['published'] = 0;
		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$product = Product::find($id);
		if (!$product) {
			$data['order'] = Product::where('catalog_id', $data['catalog_id'])->max('order') + 1;
			$product = Product::create($data);

			return ['redirect' => route('admin.catalog.productEdit', [$product->id])];
		} else {
			$product->update($data);
		}

		return ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postProductReorder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('products')->where('id', $id)->update(array('order' => $order));
		}

		return ['success' => true];
	}

	public function postUpdateOrder($id) {
		$order = Request::get('order');
		Product::whereId($id)->update(['order' => $order]);

		return ['success' => true];
	}

	public function postProductDelete($id) {
		$product = Product::findOrFail($id);
		foreach ($product->images as $item) {
			$item->deleteImage();
			$item->delete();
		}
		$product->delete();

		return ['success' => true];
	}

	public function postProductImageUpload($product_id) {
		$product = Product::findOrFail($product_id);
		$images = Request::file('images');
		$items = [];
		if ($images) foreach ($images as $image) {
			$file_name = ProductImage::uploadImage($image);
			$order = ProductImage::where('product_id', $product_id)->max('order') + 1;
			$item = ProductImage::create(['product_id' => $product_id, 'image' => $file_name, 'order' => $order]);
			$items[] = $item;
		}

		$html = '';
		foreach ($items as $item) {
			$html .= view('admin::catalog.product_image', ['image' => $item, 'active' => '']);
		}

		return ['html' => $html];;
	}

	public function postProductImageOrder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			ProductImage::whereId($id)->update(['order' => $order]);
		}

		return ['success' => true];
	}

	public function postProductImageDelete($id) {
		$item = ProductImage::findOrFail($id);
		$item->deleteImage();
		$item->delete();

		return ['success' => true];
	}

	public function getGetCatalogs($id = 0) {
		$catalogs = Catalog::whereParentId($id)->orderBy('order')->get();
		$result = [];
		foreach ($catalogs as $catalog) {
			$has_children = ($catalog->children()->count()) ? true : false;
			$result[] = [
				'id'       => $catalog->id,
				'text'     => $catalog->name,
				'children' => $has_children,
				'icon'     => ($catalog->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
			];
		}

		return $result;
	}

    public function test($id = 0) {
        $catalogs = Catalog::whereParentId($id)->orderBy('order')->get();
        $result = [];
        foreach ($catalogs as $catalog) {
            $has_children = ($catalog->children()->count()) ? true : false;
            $result[] = [
                'id'       => $catalog->id,
                'text'     => $catalog->name,
                'children' => $has_children,
                'icon'     => ($catalog->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
            ];
        }
        dd($result);
    }
}
