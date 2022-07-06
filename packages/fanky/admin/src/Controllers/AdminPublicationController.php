<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Publication;
use Illuminate\Database\Eloquent\Model;
use Request;
use Settings;
use Validator;
use Text;
use DB;
use Image;
use Thumb;
use Fanky\Admin\Models\PublicationCategory;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductImage;

class AdminPublicationController extends AdminController {

	public function getIndex() {
		$catalogs = PublicationCategory::orderBy('order')->get();

		return view('admin::publications.main', ['catalogs' => $catalogs]);
	}

	public function getGetCategories($id = 0) {
		$categories = PublicationCategory::orderBy('order')->get();
		$result = [];
		foreach ($categories as $category) {
			$pubs = Publication::where('category_id', '=', $category->id)->get();
			$has_children = [];
			foreach ($pubs as $pub) {
				$has_children[] = [
					'id' => 'pub_' . $pub->id,
					'text' => $pub->name,
					'icon' => ($pub->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
				];
			}
			$result[] = [
				'id' => 'cat_' . $category->id,
				'text' => $category->name,
				'children' => $has_children,
			];
		}

		return $result;
	}

	public function getGetPublications($id = 0) {
		$result = [];
		$pubs = Publication::where('category_id', '=', $id)->orderBy('id')->get();
		foreach ($pubs as $pub) {
			$result[] = [
				'id' => 'pub_' . $pub->id,
				'text' => $pub->name,
				'children' => false,
				'icon' => ($pub->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
			];
		}

		return $result;
	}

	//-------------------------

	public function getCategoryEdit($id = null) {
		$catalogs = PublicationCategory::orderBy('order')->get();

		return view('admin::publications.main', [
			'catalogs' => $catalogs,
			'content' => $this->postCategoryEdit($id)
		]);
	}

	public function postCategoryEdit($id = null) {
		if (!$id || !($category = PublicationCategory::find($id))) {
			$category = new PublicationCategory;
		}
		$categories = PublicationCategory::orderBy('order')
			->where('id', '!=', $category->id)->get();

		return view('admin::publications.category_edit', [
			'category' => $category, 'catalogs' => $categories,
		]);
	}

	public function postCategorySave(): array {
		$id = Request::input('id');
		$data = Request::except(['id']);

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];

		// валидация данных
		$validator = Validator::make($data, [
			'name' => 'required',
		]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем категорию
		if($id) {
			$category = PublicationCategory::find($id);
			$category->update($data);
			return ['success' => true, 'msg' => 'Изменения сохранены'];
		} else {
			$data['order'] = PublicationCategory::all()->max('order') + 1;
			$category = PublicationCategory::create($data);

			return ['redirect' => route('admin.publications.categoryEdit', [$category->id])];
		}
	}

	public function postCategoryDelete($id) {
		try {
			$category = PublicationCategory::findOrFail($id);
			$pubs = Publication::where('category_id', '=', $id)->get();

			if($pubs) {
				foreach ($pubs as $pub) {
					$pub->delete();
				}
			}

			$category->delete();

		} catch(\Exception $e) {
			return ['success' => false];
		}

		return ['success' => true];
	}


	public function getPublicationEdit($id = null) {
		$pub = Publication::find($id);

		return view('admin::publications.main', [
			'catalogs' => $pub,
			'content' => $this->postPublicationEdit($id)
		]);
	}

	public function postPublicationEdit($id = null) {
		if (!$id || !($pub = Publication::find($id))) {
			$pub = new Publication;
			$pub->published = 1;
			$pubCategory = PublicationCategory::first();
			$categories = PublicationCategory::orderBy('order')
				->where('id', '!=', 1)->get();
		} else {
			$pub = Publication::findOrFail($id);
			$pubCategory = PublicationCategory::find($pub->category_id);
			$categories = PublicationCategory::orderBy('order')
				->where('id', '!=', $id)->get();
		}

		return view('admin::publications.publication_edit', [
			'pub' => $pub,
			'pubCategory' => $pubCategory->name,
			'categories' => $categories
		]);
	}

	public function postPublicationSave(): array {
		$id = Request::input('id');
		$data = Request::except(['id', 'image']);
		if (!array_get($data, 'published')) $data['published'] = 0;
		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];
		if (!array_get($data, 'category_id')) $data['category_id'] = 0;

		// валидация данных
		$validator = Validator::make($data,	[
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем статью
		if($id) {
			$pub = Publication::findOrFail($id);
			$pub->update($data);
			return ['success' => true, 'msg' => 'Изменения сохранены'];
		} else {
			$data['order'] = Publication::all()->max('order') + 1;
			$pub = Publication::create($data);

			return ['redirect' => route('admin.publications.categoryEdit', [$pub->id])];
		}
	}

	public function postPublicationDelete($id) {
		$pub = Publication::findOrFail($id);

		// создать модель publicationImage ???
//		if($pub->images) {
//			foreach ($pub->images as $image) {
//				$image->deleteImage();
//				$image->delete();
//			}
//		}

		$pub->delete();

		return ['success' => true];
	}


	//--------------------------

	public function postPublicationCategoryReorder() {
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

	public function postPublicationCategoryDelete($id) {
		$catalog = PublicationCategory::findOrFail($id);
		$catalog->delete();

		return ['success' => true];
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

}
