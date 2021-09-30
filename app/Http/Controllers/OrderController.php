<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{

    /**
     * Index page of orders
     */
    public function index()
    {
        return view('home.order.index', [
            'orders' => Order::orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }

    /**
     * Create new order
     * @param Illuminate\Http\Request $request 
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'phone' => 'required|max:20|string',
            'size' => 'max:20',
            'price' => 'max:20',
            'useMessager' => 'max:20',
        ]);
        // todo add event for create new order
        Product::findOrFail($request->productId)->increment('orders');
        $o = new Order();
        $o->phone = $request->phone;
        $o->product_id = $request->productId;
        if (!empty($request->size)) {
            $o->size = $request->size;
        }
        if (!empty($request->useMessager)) {
            $o->use_message = true;
        }
        if (!empty($request->price)) {
            $o->price = $request->price;
        }
        $o->ip = $request->ip();
        $o->save();
        return response($o->jsonSerialize(), 200);
    }

    /**
     * Get count new orders,
     */
    public function countNewOrders()
    {
        $count = 0;
        $os = Order::whereNew(true)->get();
        if ($os) {
           $count = $os->count();
        }
        return response()->json([
            'newOrders' => $count,
        ]);
    }

    /**
     * Disable new status of order
     */
    public function disableNew(Order $order)
    {
        $order->new = false;
        $order->save();
        return redirect()->route('home.order.index');
    }
}
