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
    static public function saveOrdered(int $userId )
    {
        /**
         * FIX bug added orders
         */
        $ps = Product::select('id')->get();
        if ($ps) {
            foreach($ps as $p) {
                if (isset($_COOKIE['orderFor_'.$p->id])) {
                    $val = explode('|',  $_COOKIE['orderFor_'.$p->id]);
                    if (!empty($val[0]) && !empty($val[1])) {
                        $uo = new UserOrder();
                        $uo->user_id = $userId;
                        $uo->order_id = (int) $val[0];
                        $uo->product_id = (int) $val[1];
                        if (!UserOrder::where([
                            ['user_id', '=', $userId],
                            ['order_id', '=', (int) $val[0]],
                            ['product_id', '=', (int) $val[1]],
                        ])->first()) {
                            $uo->save();
                        }
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
            'countOrders' => auth()->user()->orders()->get()->count(),
            'orders' => auth()->user()->orders()
                ->orderBy('created_at', 'desc')
                ->paginate(env('PER_PAGE', 20))
        ]);
    }
}
