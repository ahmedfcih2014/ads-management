<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return CategoryResource
     */
    public function index()
    {
        return CategoryResource::collection(Category::withCount('ads')->get());
    }

    /**
     * Store a newly created resource in storage.
     * @param  CategoryRequest  $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        $c = Category::create($request->validated());
        return CategoryResource::make($c);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return CategoryResource
     */
    public function show($id)
    {
        return CategoryResource::make(Category::withCount('ads')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     * @param  CategoryRequest  $request
     * @param  int  $id
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, $id)
    {
        $c = Category::findOrFail($id);
        $c->update($request->validated());
        return CategoryResource::make($c);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return CategoryResource | Response
     */
    public function destroy($id)
    {
        $c = Category::findOrFail($id);
        if ($c->ads->count() > 0) {
            return $this->returnForbiden("Please delete ads related to this category first");
        }
        $c->delete();
        return CategoryResource::make($c);
    }
}
