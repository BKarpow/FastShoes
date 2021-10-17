<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSection;

class SitemapXmlController extends Controller
{
    /**
     * Site map from products.
     */
    public function products()
    {
        return response()->view('sitemapProduct', [
            'products' => Product::whereShow(true)->orderBy('created_at', 'desc')->get(),
            'categories' => Category::whereShow(true)->orderBy('created_at', 'desc')->get(),
            'sections' => ProductSection::whereShow(true)->orderBy('created_at', 'desc')->get(),
        ])->header('Content-type', 'text/xml');
    }

    /**
     * Html map site
     *
     */
    public function htmlMap()
    {
        return view('map', [
            'sections' => ProductSection::whereShow(true)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
