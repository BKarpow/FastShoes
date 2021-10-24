<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\LikeProduct;

class LikeProductController extends Controller
{
    /**
     * Getting likes from product
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function likesFromProduct(Request $request)
    {
        $request->validate([
            'productId' => 'required|numeric'
        ]);
        return response()->json([
            'productId' => (int) $request->productId,
            'likes' => Product::findOrFail((int)$request->productId)->likes()->count(),
        ]);
    }

    /**
     * Like toggle for product
     * 
     * @param App\Models\Product
     * @return Illuminate\Http\Response
     */
    public function likeProduct(Product $product)
    {
        $like = auth()->user()->likes()->whereProductId($product->id)->first();
        $response = ['like' => false];
        if (!$like) {
            $like = new LikeProduct();
            $like->user_id = auth()->id();
            $like->product_id = $product->id;
            $like->save();
            $response['like'] = true;
        } else {
            $like->delete();
        }
        return response()->json($response ,Response::HTTP_OK);
    }

    /**
     * Show list likes in cabinet
     */
    public function index()
    {
        return view('likes', [
            'likes' => auth()->user()->likes()->paginate(env('PER_PAGE', 15))
        ]);
    }
}
