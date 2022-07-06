<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PageRepositoryInterface;
use DB;
use Fanky\Admin\Models\News;
use Fanky\Admin\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;

class NewsRepository implements Interfaces\NewsRepositoryInterface {
    public function getByAlias($alias): ?News{
        return News::whereAlias($alias)
            ->public()->first();
    }

    public function getBread(News $news){
        $page = app(PageRepositoryInterface::class)->getByPath(['news']);
        $bread = $page->getBread();
        $bread[] = [
            'name' => $news->name,
            'url' => $news->url
        ];

        return $bread;
    }

    public function getLast($limit = 5) {
        return News::getLast(Settings::get('news_on_main', 5));
    }

    public function getArchiveYears() {
        $years = News::groupBy(DB::raw('YEAR(date)'))
            ->orderByDesc('date')
            ->get([DB::raw('YEAR(date) as y')])->pluck('y');
        $yearCollection = collect();
        foreach($years as $year){
            $isActive = (Request::routeIs('news.archive')
                && Request::route()->parameter('year') == $year);
            $yearCollection->push((object)[
                'year' => $year,
                'url' => route('news.archive', $year),
                'active' => $isActive
            ]);
        }

        return $yearCollection;
    }

    public function getAllWithPaginate($perPage): LengthAwarePaginator{
        return News::orderBy('date', 'desc')
            ->public()->paginate($perPage);
    }

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator{
        return News::orderBy('date', 'desc')
            ->year($year)
            ->public()->paginate($perPage);
    }
}