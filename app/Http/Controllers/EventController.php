<?php namespace App\Http\Controllers;

use App;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use Request;
use Settings;
use View;

class EventController extends Controller {
    protected $pageRepository, $newsRepository;

    public function __construct(PageRepositoryInterface $pageRepository, EventRepositoryInterface $newsRepository) {
        $this->pageRepository = $pageRepository;
        $this->newsRepository = $newsRepository;
    }

    public function index() {
        $page = $this->pageRepository->getByPath(['about', 'sobytiya']);
        if(!$page) abort(404, 'Страница не найдена');
        $items = $this->newsRepository
            ->getAllWithPaginate(Settings::get('news_per_page'));
        $archive = $this->newsRepository->getArchiveYears();
        if(count(Request::query())) {
            View::share('canonical', $page->url);
        }
        $page->setSeo();

        return view('event.index', [
            'items'        => $items,
            'h1'           => $page->getH1(),
            'name'         => $page->name,
            'text'         => $page->text,
            'bread'        => $page->getBread(),
            'archiveYears' => $archive,
        ]);
    }

    public function item($alias) {
        $page = $this->pageRepository->getByPath(['about', 'sobytiya']);
        if(!$page) abort(404);
        $item = $this->newsRepository->getByAlias($alias);
        if(!$item) abort(404);
        $bread = $this->newsRepository->getBread($item);
        $item->setSeo();;

        return view('event.item', [
            'h1'          => $item->getH1(),
            'text'        => $item->text,
            'bread'       => $bread,
        ]);
    }

    public function archive($year) {
        $page = $this->pageRepository->getByPath(['about', 'sobytiya']);
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
            'url'  => route('event.archive', $year),
            'name' => $year
        ];

        return view('event.index', [
            'items'        => $items,
            'h1'           => $page->getH1() . " $year",
            'name'         => $page->name,
            'text'         => $page->text,
            'bread'        => $bread,
            'archiveYears' => $archive,
        ]);
    }
}
