<?php namespace App\Providers;

use Fanky\Admin\Models\GalleryItem;
use Request;
use Cache;
use DB;
use Fanky\Admin\Models\News;
use Illuminate\Support\ServiceProvider;
use View;
use Cart;
use Fanky\Admin\Models\Page;

class SiteServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// пререндер для шаблона
		View::composer(['pages.unique.about'], function (\Illuminate\View\View $view) {
			$images = GalleryItem::orderBy('order')
                ->whereGalleryId(1)
                ->get();

            $view->with([
                'images' => $images,
            ]);
		});
	}
	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('settings', function () {
			return new \App\Classes\Settings();
		});
		$this->app->bind('sitehelper', function () {
			return new \App\Classes\SiteHelper();
		});
		$this->app->alias('settings', \App\Facades\Settings::class);
		$this->app->alias('sitehelper', \App\Facades\SiteHelper::class);
	}
}
