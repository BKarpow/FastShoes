<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'comment' => 'required|string|max:249',
            'productId' => 'required|exists:products,id',
            'rating' => 'string',
        ]);
        
        $rating = intval($request->rating);
        if ($rating > 5) {
            $rating = 5;
        } elseif ($rating < 0) {
            $rating = 0;
        } 
        $r = new Review();
        $r->user_id = auth()->user()->id;
        $r->product_id = $request->productId;
        $r->comment = $request->comment;
        $r->rating = $rating;
        $r->ip = $request->ip();
        $r->save();
        return response($r->jsonSerialize());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }

    /**
     * Return resource reviews from product.
     * @return App\Http\Resources\ReviewResource 
     * @param int $product_id
     */
    public function fromProductId($product_id)
    {
        return ReviewResource::collection(
            Review::orderBy('created_at', 'desc')->where([
                'product_id' => (int)$product_id,
                'moderate' => true,
            ])->paginate(env('PAGINATE_REVIEWS', 15))
        );
    }

    /**
     * Return computed rating from product
     * @param int $product_id
     * @return string $jsonResponse
     */
    public function computedRatingFromProductId($product_id)
    {
        $rating = ['rating' => 0];
        $reviews = Review::where([
            'product_id' => (int)$product_id,
            'moderate' => true,
        ])->select('rating')->get();
        if ($reviews) {
            $rtSumm = 0;
            foreach($reviews as $r) {
                $rtSumm += (int) $r->rating;
            }
            $rating['rating'] = round( (float)($rtSumm / $reviews->count()), 1 );
        }
        return response()->json($rating);
    }
}
