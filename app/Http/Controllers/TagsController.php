<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Response;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TagResource::collection(Tag::withCount('ads')->get());
    }

    /**
     * Store a newly created resource in storage.
     * @param  TagRequest  $request
     * @return TagResource
     */
    public function store(TagRequest $request)
    {
        $t = Tag::create($request->validated());
        return TagResource::make($t);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return TagResource
     */
    public function show($id)
    {
        return TagResource::make(Tag::withCount('ads')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     * @param  TagRequest  $request
     * @param  int  $id
     * @return TagResource
     */
    public function update(TagRequest $request, $id)
    {
        $t = Tag::findOrFail($id);
        $t->update($request->validated());
        return TagResource::make($t);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return TagResource | Response
     */
    public function destroy($id)
    {
        $t = Tag::findOrFail($id);
        if ($t->ads->count() > 0) {
            return response(
                [
                    'message' => "Please delete ads related to this tag first"
                ], Response::HTTP_FORBIDDEN
            );
        }
        $t->delete();
        return TagResource::make($t);
    }
}
