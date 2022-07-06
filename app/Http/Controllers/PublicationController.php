<?php namespace App\Http\Controllers;

use App;
use App\Repositories\Interfaces\PublicationsRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use Fanky\Admin\Models\Publication;
use Fanky\Admin\Models\PublicationCategory;
use Request;
use Settings;
use View;

class PublicationController extends Controller {
    protected $pageRepository, $publicationsRepository;

	public function __construct(PageRepositoryInterface $pageRepository, PublicationsRepositoryInterface $publicationsRepository) {
        $this->pageRepository = $pageRepository;
        $this->publicationsRepository = $publicationsRepository;
	}

    public function index() {
        $page = $this->pageRepository->getByPath(['publications']);
        if(!$page) abort(404, 'Страница не найдена');
        $items = [];
        $categories = PublicationCategory::all()->sortBy('order');
        foreach ($categories as $category) {
            $items[] = array(
                'name' => $category->title,
                'articles' => Publication::where('category_id', '=', $category->id)->get());
        }

        if(count(Request::query())) {
            View::share('canonical', $page->url);
        }
        $page->setSeo();

        return view('publications.index', [
            'items'        => $items,
            'h1'           => $page->getH1(),
            'name'         => $page->name,
            'title'         => $page->description,
            'bread'        => $page->getBread(),
        ]);
    }

	public function item($alias) {
		$item = Publication::whereAlias($alias)->public()->first();
		if (!$item) abort(404);
		$bread = $this->publicationsRepository->getBread($item);

        //ссылки предыдущая/следующая статья
        $currentId = $item->id;
        $pubsInCategory = Publication::where('category_id', '=', $item->category_id)->get();
        $hasPrev = $pubsInCategory->where('id', '<', $currentId)->max();
        $hasNext = $pubsInCategory->where('id', '>', $currentId)->min();

		return view('publications.item', [
			'item'        => $item,
			'h1'          => $item->name,
			'name'        => $item->name,
			'text'        => $item->text,
			'bread'       => $bread,
			'title'       => $item->title,
			'keywords'    => $item->keywords,
			'description' => $item->description,
            'hasPrev' => $hasPrev->alias ?? null,
            'hasNext' => $hasNext->alias ?? null
		]);
	}
}
