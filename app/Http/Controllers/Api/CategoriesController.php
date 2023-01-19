<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'slug' => ['nullable', 'string', 'unique:categories,slug'],
            'image' => ['nullable', 'image'],
        ]);

        $category = Category::create($validated);

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::with('parent', 'products')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'parent_id' => ['required', 'int', 'exists:categories,id'],
            'slug' => ['nullable', 'string', 'unique:categories,slug'],
            'image' => ['nullable', 'image'],
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return [
            'code' => 100,
            'status' => 'updated',
            'category' => $category,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('categories.create')) {
            return response([
                'message' => 'You are not allowed to delete category',
            ], 403);
        }

        Category::destroy($id);
        return [
            'code' => 100,
            'status' => 'deleted',
        ];
    }
}
