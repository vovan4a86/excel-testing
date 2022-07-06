<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//$cities = \Fanky\Admin\Models\City::select('alias')->get()->implode('alias', '|');
//Route::pattern('city', $cities);
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WelcomeController;

Route::post('/qwe', [\Fanky\Admin\Controllers\AdminStockController::class, 'parse'])->name('qwe');

Route::pattern('alias', '([A-Za-z0-9\-\/_]+)');
Route::pattern('id', '([0-9]+)');
Route::pattern('year', '([0-9]{4})');
Route::get('robots.txt', 'PageController@robots')->name('robots');
Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'middleware' => ['bindings']], function () {
	Route::post('callback', [AjaxController::class, 'postCallback'])
        ->name('callback');
	Route::post('question', [AjaxController::class, 'postQuestion'])
        ->name('question');
    Route::post('to-cart/{stockItem}', [AjaxController::class, 'toCart'])
        ->name('to-cart');
    Route::post('remove-from-cart/{stockItem}', [AjaxController::class, 'removeFromCart'])
        ->name('remove-from-cart');
    Route::post('order', [AjaxController::class, 'order'])
        ->name('order');
});
Route::group(['middleware' => ['redirects']], function() {
	Route::get('/', [WelcomeController::class, 'index'])
		->name('main');

    Route::group(['prefix' => 'news', 'as' => 'news'], function(){
        Route::any('/', [NewsController::class, 'index']);
        Route::get('{year}-01', [NewsController::class, 'archive'])
            ->name('.archive');
        Route::get('{name}', [NewsController::class, 'item'])
            ->name('.item');
    });

    Route::get('cart', [PageController::class, 'cart'])
        ->name('cart');

    Route::group(['prefix' => 'about/sobytiya', 'as' => 'event'], function(){
        Route::any('/', [EventController::class, 'index']);
        Route::get('{year}-01', [EventController::class, 'archive'])
            ->name('.archive');
        Route::get('{name}', [EventController::class, 'item'])
            ->name('.item');
    });

    Route::group(['prefix' => 'publications', 'as' => 'publications'], function(){
        Route::get('/', 'PublicationController@index')
            ->name('.index');
        Route::get('{alias}', 'PublicationController@item')
            ->name('.item');
    });


    Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);
	Route::any('catalog/{alias}', ['as' => 'catalog.view', 'uses' => 'CatalogController@view']);

    Route::group(['prefix' => 'sklad', 'as' => 'stocks'], function(){
        Route::get('/', [StockController::class, 'index']);
        Route::get('{stockAlias}', [StockController::class, 'stock'])
            ->name('.stock');
        Route::get('{stockAlias}/{id}', [StockController::class, 'stockItem'])
            ->name('.item');
    });

	Route::any('{alias}', ['as' => 'default', 'uses' => 'PageController@page']);
});
