<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCart as OrderCartMessage;

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

    /**
     * Create new order from cart
     * @param Illuminate\Http\Request $request 
     * @return Illuminate\Http\Response 
     */
    public function createOrders(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:15|max:18|string',
        ]);
        $productsFromCart = $this->getOrCreate()->products()->get();
        if ($productsFromCart) {
            $fp = 0;
            foreach($productsFromCart as $product) {
                //Create Orders
                $o = new Order();
                $o->phone = $request->phone;
                $o->ip = $request->ip();
                $o->size = $product->size;
                $o->product_id = $product->product_id;
                $o->price = $product->product->price;
                $fp += $product->product->price;
                $o->count = $product->count;
                $o->save();
                //User order cabinet
                $uo = new UserOrder();
                $uo->user_id = auth()->id();
                $uo->product_id = $product->product_id;
                $uo->order_id = $o->id;
                $uo->save();
                // Delete item for cart list
                $product->delete();
            }
            Mail::to( auth()->user()->email )
            ->send(new OrderCartMessage([
                'products' => $productsFromCart,
                'fullPrice' => $fp,
                'phone' => $request->phone,
            ]));
        }
        
        return redirect()->route('cart'
        )->withStatus('Заказ создан, ожидайте с Вами скоро свяжутся для уточнения деталей отправки.');
    }
}
