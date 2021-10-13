<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Validation\Rules\Exists;

class CartController extends Controller
{

    public function getCartSum()
    {
        $sum = 0;
        if (auth()->check()) {
            $sum = $this->calcSum();
        }
        return response()->json(['sum' => $sum]);
    }

    


    /**
     * Create new cart if it not exists.
     * @return Cart|null
     */
    private function getOrCreate()
    {
        $uid = auth()->id();
        if ($uid) {
            $cart = Cart::whereUserId($uid)->first();
            if ($cart) {
                return $cart;
            } else {
                $cart = new Cart();
                $cart->user_id = $uid;
                $cart->type = 'cart';
                $cart->save();
                return $cart;
            }
        }
    }

    /**
     * Calc sum prices in cart
     * @return int $sum
     */
    private function calcSum():int
    {
        $sum = 0;
        $ordersCart = $this->getOrCreate()
                                ->products()
                                ->get();
        if ($ordersCart) {
            foreach($ordersCart as $o) {
                $sum += ($o->product->price * $o->count);
            }
        }
        return $sum;
    }

    /**
     * Method index by cart page.
     */
    public function index()
    {
        $ordersCart = $this->getOrCreate()
                                ->products()
                                ->orderBy('created_at')
                                ->get();
        
        return view('cart', [
            'allPrice' => $this->calcSum(),
            'cartProducts' => $ordersCart
        ]);
    }

    /**
     * Add product to cart
     */
    public function addProduct(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'count' => 'required',
        ]);
        $cart = $this->getOrCreate();
        if ($cart){
            $cp = new CartProduct();
            $cp->cart_id = $cart->id;
            $cp->product_id = $request->productId;
            $cp->size = $request->size;
            $cp->count = (int)$request->count;
            $cp->save();
            return response()->json(['success'=>true]);
        }
    }

    /**
     * Destroy product from cart
     */
    public function destroy($id)
    {
        $cart = $this->getOrCreate();
        if ($cart) {
            $item = $cart->products()->findOrFail($id);
            $item->delete();
        }
        return redirect()->back();
    }
}
