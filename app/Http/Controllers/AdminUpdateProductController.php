<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Lib\TranslitStr;

class AdminUpdateProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Update Category product.
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function updateCategory(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'categoryId' => 'required|exists:categories,id'
        ]);
        $product = Product::findOrFail($request->productId);
        $product->category_id = $request->categoryId;
        $product->save();
        return response($product->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Update Title, price product.
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function updateTitlePrice(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'title' => 'max:150',
            'price' => 'max:10',
        ]);
        $product = Product::findOrFail($request->productId);
        if (!empty( $request->title)) {
            $product->title = $request->title;
            $product->alias = TranslitStr::convert( $request->title );
        }
        if (!empty( $request->price)) {
            $product->price = (int) $request->price;
        }
        $product->save();
        return response($product->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Update images product.
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function updateImages(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'imageOne' => 'max:250',
            'imageTwo' => 'max:250',
            'imageThree' => 'max:250',
        ]);
        $product = Product::findOrFail($request->productId);
        if (!empty( $request->imageOne)) {
            $product->image_1 = $request->imageOne;
        }
        if (!empty( $request->imageTwo)) {
            $product->image_2 = $request->imageTwo;
        }
        if (!empty( $request->imageThree)) {
            $product->image_3 = $request->imageThree;
        }
        $product->save();
        return response($product->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Update show product.
     * 
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function updateShow(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->productId);
        $product->show = ! (bool)$product->show;
        $product->save();
        return response($product->jsonSerialize(), Response::HTTP_OK);
    }
}
