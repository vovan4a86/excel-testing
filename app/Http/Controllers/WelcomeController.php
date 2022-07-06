<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\News;
use Fanky\Admin\Models\Page;
use SEOMeta;

class WelcomeController extends Controller {
    public function index() {
        $page = Page::find(1);
        $page->setSeo();
        $page->ogGenerate();
        $lastModify = Carbon::now()->subHour();
        if($response = $this->checkLastmodify($lastModify)) {
            return $response;
        }
        $catalogs = Catalog::whereIn('id', [7,3])
            ->public()
            ->orderBy('order')
            ->with(['public_children_on_main'])
            ->get();

        return response()->view('pages.index', [
            'catalogs' => $catalogs,
            'page'     => $page,
            'text'     => $page->text,
            'h1'       => $page->getH1(),
        ])->setLastModified();
    }
}
