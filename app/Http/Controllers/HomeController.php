<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('home', [
            'countProducts' => Product::all()->count(),
            'countOrders' => Order::all()->count(),
            'countNewOrders' => Order::whereNew(true)->get()->count()
        ]);
    }
}
