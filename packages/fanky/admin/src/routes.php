<?php

//Route::any('admin', ['as' => 'admin', 'uses' => 'Fanky\Admin\Controllers\AdminController@main']);
use Fanky\Admin\Controllers\AdminOrderController;
use Fanky\Admin\Controllers\AdminPublicationController;
use Fanky\Admin\Controllers\AdminStockController;

Route::group(['namespace' => 'Fanky\Admin\Controllers', 'prefix' => 'admin',
              'as' => 'admin', 'middleware' => ['bindings']], function () {
	Route::any('/', ['uses' => 'AdminController@main']);
	Route::group(['as' => '.pages', 'prefix' => 'pages'], function () {
		$controller  = 'AdminPagesController@';
		Route::get('/', $controller . 'getIndex');
		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('edit/{id?}', $controller . 'postEdit')
			->name('.edit');

		Route::get('get-pages/{id?}', $controller . 'getGetPages')
			->name('.get_pages');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('reorder', $controller . 'postReorder')
			->name('.reorder');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');

		Route::get('filemanager', [
			'as'   => '.filemanager',
			'uses' => $controller . 'getFileManager'
		]);
		Route::get('imagemanager', [
			'as'   => '.imagemanager',
			'uses' => $controller . 'getImageManager'
		]);
	});

	Route::group(['as' => '.catalog', 'prefix' => 'catalog'], function () {
		$controller  = 'AdminCatalogController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('products/{id?}', $controller . 'getProducts')
			->name('.products');

		Route::get('test/{id?}', $controller . 'test')
			->name('.test');

		Route::post('catalog-edit/{id?}', $controller . 'postCatalogEdit')
			->name('.catalogEdit');

		Route::get('catalog-edit/{id?}', $controller . 'getCatalogEdit')
			->name('.catalogEdit');

		Route::post('catalog-save', $controller . 'postCatalogSave')
			->name('.catalogSave');

		Route::post('catalog-reorder', $controller . 'postCatalogReorder')
			->name('.catalogReorder');

		Route::post('catalog-delete/{id}', $controller . 'postCatalogDelete')
			->name('.catalogDel');

		Route::get('product-edit/{id?}', $controller . 'getProductEdit')
			->name('.productEdit');

		Route::post('product-save', $controller . 'postProductSave')
			->name('.productSave');

		Route::post('product-reorder', $controller . 'postProductReorder')
			->name('.productReorder');

		Route::post('update-order/{id}', $controller . 'postUpdateOrder')
			->name('.update-order');

		Route::post('product-delete/{id}', $controller . 'postProductDelete')
			->name('.productDel');

		Route::post('product-image-upload/{id}', $controller . 'postProductImageUpload')
			->name('.productImageUpload');

		Route::post('product-image-delete/{id}', $controller . 'postProductImageDelete')
			->name('.productImageDel');

		Route::post('product-image-order', $controller . 'postProductImageOrder')
			->name('.productImageOrder');

		Route::get('get-catalogs/{id?}', $controller . 'getGetCatalogs')
			->name('.get_catalogs');
	});

	Route::group(['as' => '.news', 'prefix' => 'news'], function () {
		$controller = 'AdminNewsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

		Route::post('delete-image/{id}', $controller . 'postDeleteImage')
			->name('.delete-image');
	});

	Route::group(['as' => '.event', 'prefix' => 'event'], function () {
		$controller = 'AdminEventController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

		Route::post('delete-image/{id}', $controller . 'postDeleteImage')
			->name('.delete-image');
	});

	Route::group(['as' => '.publications', 'prefix' => 'publications'], function () {
		$controller = 'AdminPublicationsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

	});

	Route::group(['as' => '.gallery', 'prefix' => 'gallery'], function () {
		$controller = 'AdminGalleryController@';
		Route::get('/', $controller . 'anyIndex');
		Route::post('gallery-save', $controller . 'postGallerySave')
			->name('.gallerySave');
		Route::post('gallery-edit/{id?}', $controller . 'postGalleryEdit')
			->name('.gallery_edit');
		Route::post('gallery-delete/{id}', $controller . 'postGalleryDelete')
			->name('.galleryDel');
		Route::any('items/{id}', $controller . 'anyItems')
			->name('.items');
		Route::post('image-upload/{id}', $controller . 'postImageUpload')
			->name('.imageUpload');
		Route::post('image-edit/{id}', $controller . 'postImageEdit')
			->name('.imageEdit');
		Route::post('image-data-save/{id}', $controller . 'postImageDataSave')
			->name('.imageDataSave');
		Route::post('image-del/{id}', $controller . 'postImageDelete')
			->name('.imageDel');
		Route::post('image-order', $controller . 'postImageOrder')
			->name('.order');
	});

	Route::group(['as' => '.reviews', 'prefix' => 'reviews'], function () {
		$controller = 'AdminReviewsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('reorder', $controller . 'postReorder')
			->name('.reorder');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.settings', 'prefix' => 'settings'], function () {
		$controller = 'AdminSettingsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('group-items/{id?}', $controller . 'getGroupItems')
			->name('.groupItems');

		Route::post('group-save', $controller . 'postGroupSave')
			->name('.groupSave');

		Route::post('group-delete/{id}', $controller . 'postGroupDelete')
			->name('.groupDel');

		Route::post('clear-value/{id}', $controller . 'postClearValue')
			->name('.clearValue');

		Route::any('edit/{id?}', $controller . 'anyEditSetting')
			->name('.edit');

		Route::any('block-params', $controller . 'anyBlockParams')
			->name('.blockParams');

		Route::post('edit-setting-save', $controller . 'postEditSettingSave')
			->name('.editSave');

		Route::post('save', $controller . 'postSave')
			->name('.save');
	});

	Route::group(['as' => '.redirects', 'prefix' => 'redirects'], function () {
		$controller = 'AdminRedirectsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::get('delete/{id}', $controller . 'getDelete')
			->name('.delete');

		Route::post('save', $controller . 'postSave')
			->name('.save');
	});

	Route::group(['as' => '.order', 'prefix' => 'order'], function () {
		Route::get('/', [AdminOrderController::class, 'getIndex']);

        Route::get('{order}', [AdminOrderController::class, 'view'])
            ->name('.view');

        Route::post('delete/{order}', [AdminOrderController::class, 'postDelete'])
            ->name('.delete');
	});

	Route::group(['as' => '.feedbacks', 'prefix' => 'feedbacks'], function () {
		$controller = 'AdminFeedbacksController@';
		Route::get('/', $controller . 'getIndex');

		Route::post('read/{id?}',$controller . 'postRead')
			->name('.read');
		Route::post('delete/{id?}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.users', 'prefix' => 'users'], function () {
		$controller = 'AdminUsersController@';
		Route::get('/', $controller . 'getIndex');

		Route::post('edit/{id?}', $controller . 'postEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('del/{id}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.cities', 'prefix' => 'cities'], function () {
		$controller = 'AdminCitiesController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('tree/{id?}', $controller . 'postTree')
			->name('.tree');
	});

    Route::group(['prefix' => 'stock', 'as' => '.stock'], function (){
        Route::get('/', [AdminStockController::class, 'getIndex']);
        Route::post('products/{id}', [AdminStockController::class, 'postProducts'])
            ->name('.products');
        Route::get('products/{id}', [AdminStockController::class, 'getProducts'])
            ->name('.products');
        Route::post('catalog-edit/{id?}', [AdminStockController::class, 'postCatalogEdit'])
            ->name('.catalogEdit');
        Route::get('catalog-edit/{id?}', [AdminStockController::class, 'getCatalogEdit'])
            ->name('.catalogEdit');
        Route::post('catalog-save', [AdminStockController::class, 'postCatalogSave'])
            ->name('.catalogSave');
        Route::post('catalog-reorder', [AdminStockController::class, 'postCatalogReorder'])
            ->name('.catalogReorder');
        Route::post('catalog-delete/{id}', [AdminStockController::class, 'postCatalogDelete'])
            ->name('.catalogDel');
        Route::post('product-edit/{id?}', [AdminStockController::class, 'postProductEdit'])
            ->name('.productEdit');
        Route::get('product-edit/{id?}', [AdminStockController::class, 'getProductEdit'])
            ->name('.productEdit');
        Route::post('product-save', [AdminStockController::class, 'postProductSave'])
            ->name('.productSave');
        Route::post('product-reorder', [AdminStockController::class, 'postProductReorder'])
            ->name('.productReorder');
        Route::post('product-delete/{id}', [AdminStockController::class, 'postProductDelete'])
            ->name('.productDel');
        Route::post('tree', [AdminStockController::class, 'postTree'])
            ->name('.tree');
    });

    Route::group(['as' => '.publications', 'prefix' => 'publications'], function () {
        $controller  = 'AdminPublicationController@';
        Route::get('/', $controller . 'getIndex');

        Route::get('get-categories/{id?}', $controller . 'getGetCategories')
            ->name('.get_categories');

        Route::get('get-publications/{id?}', $controller . 'getGetPublications')
            ->name('.get_publications');

        Route::post('category-edit/{id?}', $controller . 'postCategoryEdit')
            ->name('.categoryEdit');

        Route::get('category-edit/{id?}', $controller . 'getCategoryEdit')
            ->name('.categoryEdit');

        Route::post('category-save', $controller . 'postCategorySave')
            ->name('.categorySave');

        Route::post('category-reorder', $controller . 'postCategoryReorder')
            ->name('.categoryReorder');

        Route::post('category-delete/{id}', $controller . 'postCategoryDelete')
            ->name('.categoryDel');

        Route::get('publication/{id?}', $controller . 'getPublications')
            ->name('.publications');

        Route::get('publication-edit/{id?}', $controller . 'getPublicationEdit')
            ->name('.publicationEdit');

        Route::post('publication-save', $controller . 'postPublicationSave')
            ->name('.publicationSave');

        Route::post('publication-reorder', $controller . 'postPublicationReorder')
            ->name('.publicationReorder');

        Route::post('publication-delete/{id}', $controller . 'postPublicationDelete')
            ->name('.publicationDel');


        Route::post('publication-image-upload/{id}', $controller . 'postPublicationImageUpload')
            ->name('.publicationImageUpload');

        Route::post('publication-image-delete/{id}', $controller . 'postPublicationImageDelete')
            ->name('.publicationImageDel');

        Route::post('publication-image-order', $controller . 'postPublicationImageOrder')
            ->name('.publicationImageOrder');
    });
});
