<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->get();

        return view('dashboard.categories.index', [
            'categories' => $categories,
        ]);
    }
}
