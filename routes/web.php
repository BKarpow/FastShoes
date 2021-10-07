<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductSectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SitemapXmlController;
use App\Http\Controllers\ReviewController;
use App\Models\Order;
use App\Models\Category;
use App\Models\ProductSection as Section;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function (Request $request) {
    dd($_COOKIE['my_phone'] ?? false);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group([
    'prefix' => '/home',
    'middleware' => 'admin',
], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

    Route::group([
        'prefix' => '/order'
    ], function () {
        Route::get('/', [OrderController::class, 'index'])->name('home.order.index');
        Route::get('/count-new', [OrderController::class, 'countNewOrders'])->name('newOrders');
        Route::get('{order}/disable-new', [OrderController::class, 'disableNew'])->name('order.disNew');
    });

    Route::get('/sections/spa', [ProductSectionController::class, 'pageHomeSpa'])
        ->name('sections.spa');
    
    Route::resource('/sections', ProductSectionController::class);
    Route::get('/category/spa', [CategoryController::class, 'indexPageSpa'])
        ->name('category.spa');
    Route::resource('/category', CategoryController::class);
    /**
     * Product Route group
     */
    Route::view('/product/spa', 'home.product.spa')->name('product.spa');
    Route::resource('/product', ProductController::class);
    Route::put('/product/{id}/price/', [ProductController::class, 'updatePrice'])
        ->name('product.update.price');
    Route::put('/product/{product}/show', [ProductController::class, 'showToggle'])
        ->name('product.update.show');

    Route::prefix('upload')->group(function () {
        Route::delete('/image/{fileId}', [FileController::class, 'delete'])->name('home.upload.delete');
        Route::post('image', [FileController::class, 'upload'])->name('home.upload.image');
    });

    
    

    Route::post('/size', [SizeController::class, 'store'])->name('size.store');
    Route::post('/color', [ColorController::class, 'store'])->name('color.store');
});

Route::group([
    'prefix' => '/product'
], function(){
    Route::get('/{product}/{alias}.html', [ProductController::class, 'showPage'])
        ->name('product.show');
});


Auth::routes();



/** Orders from user */
Route::post('/order', [OrderController::class, 'store'])->name('new.order');
/** # orders from user */

/**
 * Reviews routes
 */
Route::group([
    'prefix' => '/review',
    'middleware' => 'auth'
], function(){
    Route::post('/create', [ReviewController::class, 'store'])
    ->name('review.store');
});
 // # Reviews routes

/**
 * SPA Product app FIX route path
 */
Route::get('/section/{id}/{alias}', function ($id, $alias) {
    return view('welcome', [
        'meta' => Section::findOrFail($id),
        'isMeta' => true,
    ] );
})->name('spa.section');
Route::get('/category/{id}/{alias}', function ($id, $alias) {
    return view('welcome', [
        'meta' => Category::findOrFail($id),
        'isMeta' => true,
    ]);
})->name('spa.category');

/**
 * Sitemaps
 */
Route::get('/sitemap.xml', [SitemapXmlController::class, 'products'])->name('sitemap.product');

//Route from Google auth
Route::get('/redirect', [LoginController::class, 'redirectToProvider'])
    ->name('google.login');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);
//End Google auth
