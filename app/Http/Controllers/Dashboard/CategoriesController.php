<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
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
            //->noParent()
            ->search($request->query('search'))
            ->get();

        //dd($categories);

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

        $path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Object UploadedFile
            $path = $file->store('/uploads', 'public'); // store file in selected path!
        }

        // Mass assignment
        $slug = $request->post('slug');
        if (!$slug) {
            $slug = Str::slug( $request->post('name') );
        }

        $category = Category::create([
            'name' => $request->post('name'),
            'slug' => $slug,
            'parent_id' => $request->post('parent_id'),
            'image_path' => $path,
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

        $old = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('/uploads', 'public');
            $data['image_path'] = $path;
            $old = $category->image_path;
        }

        if (!$data['slug']) {
            $data['slug'] = Str::slug( $data['name'] );
        }

        // Mass Assignment
        $category->update($data);
        if ($old) {
            // Delete old image
            Storage::disk('public')->delete($old);
        }

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category updated.");
    }

    public function destroy($id)
    {
        //Category::destroy($id);
        $category = Category::findOrFail($id);
        $category->delete();

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
                Rule::dimensions()->minHeight(300)->maxHeight(1200)->minWidth(300)->maxWidth(1200),
            ],
        ];

        $messages = [
            'name.required' => ':attribute required!!',
            'unique' => 'Already used!',
        ];

        return $request->validate($rules, $messages);
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('dashboard.categories.trash', [
            'categories' => $categories,
        ]);
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.index')
            ->with('success', "Category {$category->name} restored!");
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success', "Category {$category->name} deleted forever!");
    }
}
