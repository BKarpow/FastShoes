<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Lib\TranslitStr;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryApiAllResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    /**
     * Page SPA Control category
     * @return view(home.category.spa) 
     */
    public function indexPageSpa()
    {
        return view('home.category.spa');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('created_at', 'desc')->paginate(2);
        return CategoryResource::collection($data);
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
            'sectionId' => 'required|exists:product_sections,id',
            'title' => 'required|max:150',
            'description' => 'max:1500',
            'show' => 'required',
        ]);
        $s = new Category();
        $s->section_id = $request->sectionId;
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|string|max:200|min:3',
            'description' => 'required|string|max:1500|min:5',
            'show' => 'required|min:1',
            'sectionId' => 'required|exists:product_sections,id',
        ]);
        $category = Category::findOrFail($categoryId);
        if ($category) {
            $category->title = $request->title;
            $category->alias = TranslitStr::convert( $request->title);
            $category->description = $request->description;
            $category->show = (bool)$request->show;
            $category->section_id = (int)$request->sectionId;
            $category->save();
            return response($section->jsonSerialize(), Response::HTTP_OK);
        }
        return response()->json([], 402);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($idItem)
    {
        $section = Category::findOrFail($idItem);
        if ($section) {
            $section->delete();
            return response(null, Response::HTTP_OK);
        }
        return response()->json([], 402);
    }

    /**
     * Getting all categories
     */
    public function allFromApi()
    {
        return CategoryApiAllResource::collection(Category::whereShow(true)->get());
    }

    /**
     * Getting all categories from sections
     * 
     */
    public function getAllFromSectionId(Request $request)
    {
        $request->validate([
            'sectionId' => 'required|exists:categories,section_id',
        ]);
        return CategoryApiAllResource::collection(
            Category::where([
                ['section_id', '=', $request->sectionId],
                ['show', '=', 1],
            ])->get()
        );
    }
}
