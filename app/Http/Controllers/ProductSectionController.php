<?php

namespace App\Http\Controllers;

use App\Models\ProductSection;
use App\Lib\TranslitStr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ProductSectionResource;
use App\Http\Resources\SectionApiAllResource;

class ProductSectionController extends Controller
{


    /**
     * SPA Page control sections
     * 
     */
    public function pageHomeSpa()
    {
        return view('home.productSection.spa');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductSection::whereShow(true)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return ProductSectionResource::collection($data);
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
            'title' => 'required|max:150',
            'description' => 'required|max:1500',
            'show' => 'required',
        ]);
        $s = new ProductSection();
        $s->title = $request->title;
        $s->alias = TranslitStr::convert($request->title);
        $s->description = $request->description;
        $s->show = (bool)$request->show;
        $s->save();
        return response($s->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductSection  $productSection
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSection $productSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSection  $productSection
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSection $productSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSection  $productSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idItem)
    {
        $request->validate([
            'title' => 'required|string|max:200|min:3',
            'description' => 'required|string|max:1500|min:5',
            'show' => 'required|min:1',
        ]);
        $section = ProductSection::findOrFail($idItem);
        if ($section) {
            $section->title = $request->title;
            $section->description = $request->description;
            $section->show = (bool)$request->show;
            $section->save();
            return response($section->jsonSerialize(), Response::HTTP_OK);
        }
        return response()->json([], 402);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSection  $productSection
     * @return \Illuminate\Http\Response
     */
    public function destroy($idItem)
    {
        $section = ProductSection::findOrFail($idItem);
        if ($section) {
            $section->delete();
            return response(null, Response::HTTP_OK);
        }
        return response()->json([], 402);
    }

    /**
     * Return all sections from API
     * 
     * @return SectionApiAllResource
     */
    public function allFromApi()
    {
        return SectionApiAllResource::collection(ProductSection::whereShow(true)->get());
    }
}
