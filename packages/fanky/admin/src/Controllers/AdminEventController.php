<?php namespace Fanky\Admin\Controllers;

use Request;
use Validator;
use Text;
use Fanky\Admin\Models\Event;

class AdminEventController extends AdminController {

	public function getIndex() {
		$news = Event::orderBy('date', 'desc')->paginate(100);

		return view('admin::event.main', ['news' => $news]);
	}

	public function getEdit($id = null) {
		if (!$id || !($article = Event::find($id))) {
			$article = new Event([
                'date' => date('Y-m-d'),
                'published' => 1
            ]);
		}

		return view('admin::event.edit', ['article' => $article]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::except(['id', 'image']);
		$image = Request::file('image');

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'published')) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
				'date' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = Event::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = Event::find($id);
		$redirect = false;
		if (!$article) {
			$article = Event::create($data);
			$redirect = true;
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
		}

		if($redirect){
			return ['redirect' => route('admin.event.edit', [$article->id])];
		} else {
			return ['msg' => 'Изменения сохранены.'];
		}

	}

	public function postDelete($id) {
		$article = Event::find($id);
		$article->delete();

		return ['success' => true];
	}

	public function postDeleteImage($id) {
		$news = Event::find($id);
		if(!$news) return ['error' => 'news_not_found'];

		$news->deleteImage();
		$news->update(['image' => null]);

		return ['success' => true];
	}
}
