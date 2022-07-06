<?php namespace App\Http\Controllers;

use App;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use Fanky\Admin\Models\News;
use Fanky\Admin\Models\NewsTag;
use Fanky\Admin\Models\Page;
use Request;
use Settings;
use View;

class NewsController extends Controller {
    protected $pageRepository, $newsRepository;

    public function __construct(PageRepositoryInterface $pageRepository, NewsRepositoryInterface $newsRepository) {
        $this->pageRepository = $pageRepository;
        $this->newsRepository = $newsRepository;
    }

    public function index() {
        $page = $this->pageRepository->getByPath(['news']);
        if(!$page) abort(404, 'Страница не найдена');
        $items = $this->newsRepository
            ->getAllWithPaginate(Settings::get('news_per_page'));
        $archive = $this->newsRepository->getArchiveYears();
        if(count(Request::query())) {
            View::share('canonical', $page->url);
        }
        $page->setSeo();

        return view('news.index', [
            'items'        => $items,
            'h1'           => $page->getH1(),
            'name'         => $page->name,
            'text'         => $page->text,
            'bread'        => $page->getBread(),
            'archiveYears' => $archive,
        ]);
    }

    public function item($alias) {
        $page = $this->pageRepository->getByPath(['news']);
        if(!$page) abort(404);
        $item = $this->newsRepository->getByAlias($alias);
        if(!$item) abort(404);
        $bread = $this->newsRepository->getBread($item);
        $item->setSeo();;

        return view('news.item', [
            'h1'          => $item->getH1(),
            'text'        => $item->text,
            'bread'       => $bread,
        ]);
    }

    public function archive($year) {
        $page = $this->pageRepository->getByPath(['news']);
        if(!$page) abort(404, 'Страница не найдена');
        $items = $this->newsRepository
            ->getAllByYearWithPaginate($year, Settings::get('news_per_page'));
        $archive = $this->newsRepository->getArchiveYears();
        if(count(Request::query())) {
            View::share('canonical', $page->url);
        }
        $page->setSeo();
        $bread = $page->getBread();
        $bread[] = [
            'url'  => route('news.archive', $year),
            'name' => $year
        ];

        return view('news.index', [
            'items'        => $items,
            'h1'           => $page->getH1() . " $year",
            'name'         => $page->name,
            'text'         => $page->text,
            'bread'        => $bread,
            'archiveYears' => $archive,
        ]);
    }
}
