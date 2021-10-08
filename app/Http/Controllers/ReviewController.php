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
        return view('home.review.index', [
            'reviews' => Review::orderBy('created_at', 'desc')
            ->paginate(env('PER_PAGE', 15))
        ]);
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
            'phoneOrdered' => 'required|max:19|min:18',
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
        $r->phone_ordered = $request->phoneOrdered;
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
        $review->delete();
        return redirect()->route('review');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function toggleModerate(Review $review)
    {
        $review->moderate = !$review->moderate;
        $review->save();
        return redirect()->route('review');
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
            $rtSum = 0;
            $rattingList = [];
            foreach($reviews as $r) {
                $rtSum += (int) $r->rating;
                if (isset($rattingList[$r->rating])) {
                    $rattingList[$r->rating]++;
                } else {
                    $rattingList[$r->rating] = 1;
                }
                
            }
            $rating['all'] = $rattingList;
            $rating['count'] = $reviews->count();
            // FIX division on zero
            if ($reviews->count() > 0) {
                $rating['rating'] = round( (float)($rtSum / $reviews->count()), 1 );
            } else {
                $rating['rating'] = 0.0;
            }
            
        }
        return response()->json($rating);
    }


    /**
     * Delete user review
     */
    public function deleteFromUser($review_id)
    {
        $rs = auth()->user()->reviews()->findOrFail($review_id);
        if ($rs) {
            $rs->delete();
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['message'=>'Error delete review']);
        }
    }

    /**
     * Update review
     */
    public function updateReviewOfUser(Request $request, $review_id)
    {
        $request->validate([
            'comment' => 'required|string|max:249',
            'rating' => 'string',
            'phoneOrdered' => 'required|max:19|min:18',
        ]);
        $rs = auth()->user()->reviews()->findOrFail($review_id);
        if ($rs) {
            $rs->comment = $request->comment;
            $rs->rating = $request->rating;
            $rs->phone_ordered = $request->phoneOrdered;
            $rs->save();
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['message'=>'Error delete review']);
        }
    }
}
