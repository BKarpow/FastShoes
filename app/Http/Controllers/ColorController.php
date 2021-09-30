<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use App\Models\Product;

class ColorController extends Controller
{
    /**
     * Method return resource as all colors
     * 
     */
    public function getAll()
    {
        return ColorResource::collection(
            Color::whereShow(true)
            ->orderBy('value', 'ASC')
            ->get()
        );
    }

    

    /**
     * Create new item color
     * 
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|unique:colors,value',
        ]);
        $color = new Color();
        $color->value =  mb_strtoupper( $request->value);
        $color->save();
        return response($color->jsonSerialize(), 200);
    }
}
