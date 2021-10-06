<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Lib\TranslitStr;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(
            Product::orderBy('view', 'desc')
            ->paginate(env('PRODUCT_PER_PAGE', 15))
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:250|min:5',
            'price' => 'required|max:7',
            'description' => 'max:5000',
            'colors' => 'string', 
            'sizes' => 'string', 
            
            'categoryId' => 'required|exists:categories,id',
        ]);
        $p = new Product();
        $p->title = $request->title;
        $p->alias = TranslitStr::convert( $request->title);
        $p->price = $request->price;
        $p->description = $request->description;
        $p->colors = $request->colors;
        $p->sizes = $request->sizes;
        $p->category_id = $request->categoryId;
        $p->user_id = auth()->user()->id;
        $p->image_1 = $request->image_1;
        $p->image_2 = $request->image_2;
        $p->image_3 = $request->image_3;
        $p->image_4 = $request->image_4;
        $p->image_5 = $request->image_5;
        $p->image_6 = $request->image_6;
        $p->image_7 = $request->image_7;
        $p->image_8 = $request->image_8;
        $p->save();
        return response($p->jsonSerialize(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, 200);
    }

    /**
     * Update price in the product
     * 
     */
    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'newPrice' => 'required|max:10|string',
        ]);
        $p = Product::findOrFail($id);
        $p->price = (int)$request->newPrice;
        $p->save();
        return response($p->jsonSerialize(), 200);
    }

    /**
     * Get products from categoruId and filters params
     */
    public function getFromCategoryId(Request $request)
    {
        $request->validate([
            'categoryId' => 'required|exists:categories,id',
        ]);
        $w = [
            ['show', '=', true],
            ['category_id', '=', $request->categoryId],
        ];
        if ($request->input('size', false) &&
         !$request->input('color', false)){
            $w[] = [ 'sizes', 'LIKE', "%{$request->size}%" ];
        } elseif ($request->input('size', false) &&
                    $request->input('color', false)){
           $w[] = [ 'sizes', 'LIKE', "%{$request->size}%" ];
           $w[] = [ 'colors', 'LIKE', "%{$request->color}%" ];
       } elseif (!$request->input('size', false) &&
                $request->input('color', false)){
            $w[] = [ 'colors', 'LIKE', "%{$request->color}%" ];
        } else {
            $w = $w;
        }
        if ($request->input('price', false)) {
            $t = ($request->price == 'desc') ? 'DESC' : 'ASC';
            $p = Product::where($w)->orderBy('price', $t)
            ->paginate( env('PRODUCT_PER_PAGE', 15) );
        } else {
            $p = Product::where($w)->orderBy('created_at', 'DESC')
            ->paginate( env('PRODUCT_PER_PAGE', 15) );
        }
        return ProductResource::collection($p);
    }

    /**
     * Return Images List from product
     * @param Product
     * 
     */
    public function getImagesFromProduct(Product $product)
    {
        $response['data'] = [
            0 => $product->imageItem_1(),
            1 => $product->imageItem_2(),
            2 => $product->imageItem_3(),
            3 => $product->imageItem_4(),
            4 => $product->imageItem_5(),
            5 => $product->imageItem_6(),
            6 => $product->imageItem_7(),
            7 => $product->imageItem_8(),
        ];
        return response()->json($response, 200);
    }

    /**
     * Show page routes
     */
    public function showPage(Product $product)
    {
        $product->increment('view');
        return view('product', ['product' => $product]);
    }


    /**
     * Get params from products of category
     */
    public function fromCategoryId(Request $request)
    {
        $request->validate(
            [
                'categoryId' => 'required|exists:categories,id',
            ]
        );
        $products = Product::whereCategoryId($request->categoryId)->get();
        if ($products) {
            $arrData = [];
            $arrDataSizes = [];
            $prices = [];
            foreach($products as $product) {
                $prices[] = (int)$product->price;
                if ($product->colors) {
                    $d = json_decode($product->colors, true);
                    foreach($d as $i) {
                        $arrData[$i] = (isset($arrData[$i])) ? $arrData[$i]+1 : 1 ;
                    }
                }
                if ($product->sizes) {
                    $d = json_decode($product->sizes, true);
                    foreach($d as $i) {
                        $arrDataSizes[$i] = (isset($arrDataSizes[$i])) ? $arrDataSizes[$i]+1 : 1 ;
                    }
                }
            }
            return response()->json([
                'sizes' => array_keys($arrDataSizes),
                'colors' => array_keys($arrData),
                'maxPrice' => max($prices),
                'minPrice' => min($prices),
            ], 200);
        } else {
            return response()->json(null, 205);
        } 

    }

    /**
     * Enable/Disable a visability product for page 
     */
    public function showToggle(Product $product)
    {
        $product->show = !(bool)$product->show;
        $product->save();
        response(null, 200);
    }
}
