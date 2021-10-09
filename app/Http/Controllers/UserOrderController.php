<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOrder;
use App\Models\Product;

class UserOrderController extends Controller
{
    /**
     * Method saved orders of cookie by register new user.
     */
    static public function saveOrdered()
    {
        if (!auth()->check()) {
            return false;
        }
        $ps = Product::select('id')->get();
        if ($ps) {
            foreach($ps as $p) {
                if (isset($_COOKIE['orderFor_'.$p->id])) {
                    $val = explode('|',  $_COOKIE['orderFor_'.$p->id]);
                    $uo = new UserOrder();
                    $uo->user_id = auth()->id();
                    $uo->order_id = (int) $val[0];
                    $uo->product_id = (int) $val[1];
                    if (!UserOrder::where([
                        ['user_id', '=', auth()->id()],
                        ['order_id', '=', (int) $val[0]],
                        ['product_id', '=', (int) $val[1]],
                    ])->first()) {
                        $uo->save();
                    }
                }
            }
        }
    }

    /**
     * This method for cabinet page
     */
    public function cabinet()
    {

        return view('cabinet', [
            'user' => auth()->user(),
            'orders' => auth()->user()->orders()
                ->orderBy('created_at', 'desc')
                ->paginate(env('PER_PAGE', 20))
        ]);
    }
}
