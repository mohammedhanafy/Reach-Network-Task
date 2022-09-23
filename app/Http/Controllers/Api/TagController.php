<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return TagResource::collection(Tag::all());
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            return new TagResource(Tag::create($request->only(['title'])));
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        try {
            return new TagResource($tag);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $tag->update($request->only(['title']));
            return new TagResource($tag);        
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return response()->json(['success' => 'Tag deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }
}
