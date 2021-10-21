<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;

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
}
