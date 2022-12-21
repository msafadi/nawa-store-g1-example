<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('dashboard.categories.create', [
            'category' => new Category(),
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        // $category = new Category();
        // $category->name = $request->post('name');
        // $category->slug = $request->post('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass assignment
        $slug = $request->post('slug');
        if (!$slug) {
            $slug = Str::slug( $request->post('name') );
        }

        $category = Category::create([
            'name' => $request->post('name'),
            'slug' => $slug,
            'parent_id' => $request->post('parent_id'),
        ]);

        // PRG + Flash Message
        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category created. (#{$category->id})");
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        
        $parents = Category::orderBy('name')->pluck('name', 'id');

        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        //$data = $this->validateRequest($request, $id);
        $data = $request->validated();
        if (!$data['slug']) {
            $data['slug'] = Str::slug( $data['name'] );
        }

        // $category->name = $request->post('name');
        // $category->slug = $request->post('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass Assignment
        $category->update($data);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category updated.");
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category deleted.");
    }

    protected function validateRequest(Request $request, $id = 0)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:categories,slug,$id",
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => [
                'nullable',
                'image',
                'max:100',
                //'dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200',
                Rule::dimensions()->minHeight(300)->maxHeight(1200)->minWidth(1200)->maxWidth(1200),
            ],
        ];

        $messages = [
            'name.required' => ':attribute required!!',
            'unique' => 'Already used!',
        ];

        return $request->validate($rules, $messages);
    }
}
