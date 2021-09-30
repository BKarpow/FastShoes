<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SizeResource;
use App\Models\Size;

class SizeController extends Controller
{
    /**
     * Getting all sizes resource
     * 
     */
    public function getAll()
    {
        return SizeResource::collection(
            Size::whereShow(true)
            ->orderBy('value', 'desc')
            ->get()
        );
    }


    /**
     * Create new item size
     * 
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|unique:sizes,value',
        ]);
        $size = new Size();
        $size->value = $request->value;
        $size->save();
        return response($size->jsonSerialize(), 200);
    }
}
