<?php

namespace App\Providers;

use App\Repositories\CatalogRepository;
use App\Repositories\CityRepository;
use App\Repositories\EventRepository;
use App\Repositories\Interfaces\CatalogRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\PublicationsRepositoryInterface;
use App\Repositories\Interfaces\StockItemRepositoryInterface;
use App\Repositories\Interfaces\StockRepositoryInterface;
use App\Repositories\NewsRepository;
use App\Repositories\PageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PublicationsRepository;
use App\Repositories\StockItemRepository;
use App\Repositories\StockRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
    private $bindSingle = [
        ProductRepositoryInterface::class   => ProductRepository::class,
        NewsRepositoryInterface::class      => NewsRepository::class,
        PublicationsRepositoryInterface::class      => PublicationsRepository::class,
        EventRepositoryInterface::class     => EventRepository::class,
        CityRepositoryInterface::class      => CityRepository::class,
        PageRepositoryInterface::class      => PageRepository::class,
        CatalogRepositoryInterface::class   => CatalogRepository::class,
        StockRepositoryInterface::class     => StockRepository::class,
        StockItemRepositoryInterface::class => StockItemRepository::class,
    ];

    public function register() {
        foreach($this->bindSingle as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }

    public function boot() {
        //
    }
}
