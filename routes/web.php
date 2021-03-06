<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSectionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapXmlController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AdminUpdateProductController;
use App\Http\Controllers\LikeProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductSection as Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    $t = new Telegram(env('TELEGRAM_TOKEN'));
    dd($t->getUpdates());
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.html', [SitemapXmlController::class, 'htmlMap'])
    ->name('sitemap.html');

Auth::routes();

Route::group([
    'prefix' => '/home',
    'middleware' => 'admin',
], function () {

    Route::group(['prefix' => '/review'], function () {
        Route::get('/', [ReviewController::class, 'index'])
            ->name('review');
        Route::get('/delete/{review}', [ReviewController::class, 'destroy'])
            ->name('home.review.delete');
        Route::get('/toggle-moderate/{review}', [ReviewController::class, 'toggleModerate'])
            ->name('review.toggleModerate');
    });

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::group([
        'prefix' => '/order',
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
    Route::get('/product/{product}/edit-page', [ProductController::class, 'edit']);
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

/**
 * Admin update routes
 */
Route::group([
    'prefix' => '/admin',
    'middleware' => 'admin',
], function(){
    Route::group([
        'prefix' => '/product'
    ], function () {
        Route::put('/', [AdminUpdateProductController::class, 'updateCategory']);
        Route::put('/title-price', [AdminUpdateProductController::class, 'updateTitlePrice']);
        Route::put('/images', [AdminUpdateProductController::class, 'updateImages']);
        Route::put('/show', [AdminUpdateProductController::class, 'updateShow']);
    });
});

Route::group([
    'prefix' => '/product',
], function () {
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
    'middleware' => 'auth',
], function () {
    Route::post('/create', [ReviewController::class, 'store'])
        ->name('review.store');
    Route::delete('/{reviewId}', [ReviewController::class, 'deleteFromUser'])
        ->name('review.delete');
    // updateReviewOfUser
    Route::put('/{reviewId}', [ReviewController::class, 'updateReviewOfUser'])
        ->name('review.update');
});
// # Reviews routes

/**
 * Cart routes
 */
Route::post('/cart/sum', [CartController::class, 'getCartSum']);
Route::group([
    'prefix' => '/cart',
    'middleware' => 'auth',
], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::get('/delete-product/{id}', [CartController::class, 'destroy'])->name('cart.delete');

    Route::post('/add', [CartController::class, 'addProduct'])
        ->name('cart.addProduct');
    Route::post('/cart/order', [CartController::class, 'createOrders'])
        ->name('cart.order');

});
// # Cart routes

/**
 * SPA Product app FIX route path
 */
Route::get('/section/{id}/{alias}', function ($id, $alias) {
    return view('welcome', [
        'meta' => Section::findOrFail($id),
        'isMeta' => true,
    ]);
})->name('spa.section');
Route::get('/category/{id}/{alias}', function ($id, $alias) {
    return view('welcome', [
        'meta' => Category::findOrFail($id),
        'isMeta' => true,
    ]);
})->name('spa.category');
Route::get('/search', function () {
    return view('welcome');
})->name('spa.search');

/**
 * Sitemaps
 */
Route::get('/sitemap.xml', [SitemapXmlController::class, 'products'])->name('sitemap.product');

/**
 * MyCabinet
 */
Route::group([
    'prefix' => '/my',
    'middleware' => 'auth',
], function () {
    Route::get('/', [UserOrderController::class, 'cabinet'])
        ->name('cabinet.index');
    Route::get('/likes', [LikeProductController::class, 'index'])
        ->name('cabinet.like');
});

Route::group([
    'prefix' => '/like',
    'middleware' => 'auth',
], function () {
    Route::get('/{product}', [LikeProductController::class, 'likeProduct'])
        ->name('product.like');
});



/**
 * Feedback routes;
 *
 */
Route::post('/feedback', [FeedbackController::class, 'store'])
    ->name('feedback.store');

/** Pages */
Route::view('/about', 'pages.about')->name('about');

//Route from Google auth
Route::get('/redirect', [LoginController::class, 'redirectToProvider'])
    ->name('google.login');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);
//End Google auth