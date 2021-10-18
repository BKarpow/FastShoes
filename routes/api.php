<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductSectionController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/route', function(Request $request) {
    $request->validate([
        'name' => 'required|string|max:50|min:2',
        'params' => 'string',
    ]);
    if (!empty($request->params)) {
        $res = route($request->name, json_decode($request->params, true));
    } else {
        $res = route($request->name);
    }
    return response()->json($res, 200);
});

Route::prefix('section')->group(function () {
    Route::get('/', [ProductSectionController::class, 'allFromApi'])
        ->name('api.section.all');
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'allFromApi'])->name('api.category.all');
    Route::get('/from', [CategoryController::class, 'getAllFromSectionId']);
});

Route::prefix('product')->group(function () {
    Route::get('/category-id', [ProductController::class, 'getFromCategoryId']);
    Route::get('/{product}/images', [ProductController::class , 'getImagesFromProduct']);
    Route::get('/last', [ProductController::class , 'lastProduct']);
});

Route::group([
    'prefix' => '/reviews',
], function(){
    Route::get('/from/{product_id}', [ReviewController::class, 'fromProductId']);
    Route::get('/rating/from/{product_id}', [ReviewController::class, 'computedRatingFromProductId']);
});

Route::get('/size', [SizeController::class, 'getAll'])->name('api.size.all');
Route::get('/color', [ColorController::class, 'getAll'])->name('api.color.all');

/**
 * Products params
 */
Route::get('/product/params-from', [ProductController::class, 'fromCategoryId']);

Route::get('/file/uri', [FileController::class, 'getItemFileFromUri']);
