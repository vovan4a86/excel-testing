<?php namespace App\Http\Controllers;

use App;
use Cart;
use Fanky\Admin\Models\Page;
use SEOMeta;
use SiteHelper;

class PageController extends Controller {

    public function page($alias) {
        $path = explode('/', $alias);
        $page = Page::getByPath($path);
        if(!$page) abort(404, 'Страница не найдена');
        $page->setSeo();
        $stockItems = $page->stock_items_public;

        return view($page->getViewName(), [
            'stockItems' => $stockItems,
            'page'       => $page,
            'h1'         => $page->getH1(),
            'text'       => $page->text,
            'bread'      => $page->getBread(),
        ]);
    }

    public function robots() {
        $robots = new App\Robots();
        if(App::isLocal()) {
            $robots->addUserAgent('*');
            $robots->addDisallow('/');
        } else {
            $robots->addUserAgent('*');
            $robots->addDisallow('/admin');
            $robots->addDisallow('/ajax');
        }

        $robots->addHost(config('app.url'));
        $robots->addSitemap(url('sitemap.xml'));

        $response = response($robots->generate())
            ->header('Content-Type', 'text/plain; charset=UTF-8');
        $response->header('Content-Length', strlen($response->getOriginalContent()));

        return $response;
    }

    public function cart() {
        $page = Page::getByPath(['cart']);
        if(!$page) abort(404, 'Страница не найдена');
        $page->setSeo();
        $items = Cart::getCart();

        return view('pages.cart', [
            'items' => $items,
            'page'  => $page,
            'h1'    => $page->getH1(),
            'text'  => $page->text,
            'bread' => $page->getBread(),
        ]);
    }
}
