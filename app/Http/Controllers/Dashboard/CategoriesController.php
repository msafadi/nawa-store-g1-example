<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        // SQL:
        // SELECT categories.*, parents.name as parent_name FROM categories
        // LEFT JOIN categories as parents ON parents.id = categories.parent_id
        // 
        $categories = Category::select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->get();

        return view('dashboard.categories.index', [
            'categories' => $categories,
            'status' => session('status'),
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name', 'ASC')->get();

        return view('dashboard.categories.create', [
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        //
        // $category = new Category();
        // $category->name = $request->post('name');
        // $category->slug = $request->post('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass assignment
        $category = Category::create([
            'name' => $request->post('name'),
            'slug' => $request->post('slug'),
            'parent_id' => $request->post('parent_id'),
        ]);

        // PRG + Flash Message
        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', "Category created. (#{$category->id})");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        
        $parents = Category::orderBy('name')->get();

        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // $category->name = $request->post('name');
        // $category->slug = $request->post('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass Assignment
        $category->update([
            'name' => $request->post('name'),
            'slug' => $request->post('slug'),
            'parent_id' => $request->post('parent_id'),
        ]);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', "Category updated.");
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', "Category deleted.");
    }
}
