<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return CategoryResource::collection(Category::all());
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
    public function store(CategoryRequest $request)
    {
        try {
            return new CategoryResource(Category::create($request->only(['title', 'description'])));
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        try {
            return new CategoryResource($category);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->only(['title', 'description']));
            return new CategoryResource($category);        
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['success' => 'Category deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }
}
