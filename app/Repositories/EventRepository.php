<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PageRepositoryInterface;
use DB;
use Fanky\Admin\Models\Event;
use Fanky\Admin\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;

class EventRepository implements Interfaces\EventRepositoryInterface {
    public function getByAlias($alias): ?Event{
        return Event::whereAlias($alias)
            ->public()->first();
    }

    public function getBread(Event $news){
        $page = app(PageRepositoryInterface::class)->getByPath(['about', 'sobytiya']);
        $bread = $page->getBread();
        $bread[] = [
            'name' => $news->name,
            'url' => $news->url
        ];

        return $bread;
    }

    public function getLast($limit = 5) {
        return Event::getLast(Settings::get('news_on_main', 5));
    }

    public function getArchiveYears() {
        $years = Event::groupBy(DB::raw('YEAR(date)'))
            ->orderByDesc('date')
            ->get([DB::raw('YEAR(date) as y')])->pluck('y');
        $yearCollection = collect();
        foreach($years as $year){
            $isActive = (Request::routeIs('event.archive')
                && Request::route()->parameter('year') == $year);
            $yearCollection->push((object)[
                'year' => $year,
                'url' => route('event.archive', $year),
                'active' => $isActive
            ]);
        }

        return $yearCollection;
    }

    public function getAllWithPaginate($perPage): LengthAwarePaginator{
        return Event::orderBy('date', 'desc')
            ->public()->paginate($perPage);
    }

    public function getAllByYearWithPaginate($year, $perPage): LengthAwarePaginator{
        return Event::orderBy('date', 'desc')
            ->year($year)
            ->public()->paginate($perPage);
    }
}