<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Category;

use Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(auth()->user()->admin_role !== 1){
            return redirect()->back()->with('error', 'Unauthorized page!');
        }

        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    
    public function create()
    {
        if(auth()->user()->admin_role !== 1){
            return redirect()->back()->with('error', 'Unauthorized page!');
        }

        $category = new Category();
        return view('admin.category.create', compact('category'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'category_name' => ['required', 'string']
        ]);

        $slug = Str::kebab($request->category_name);
        $slug = $slug.'-'.time();

        Category::create([
            'category_name' => $request->category_name,
            'category_status' => 'active',
            'category_slug' => $slug,
        ]);

        return redirect()->back()->with('success', 'Category data has been created.');
    }

    public function edit(Category $category)
    {
        if(auth()->user()->admin_role !== 1){
            return redirect()->back()->with('error', 'Unauthorized page!');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
       $data = request()->validate([
            'category_name' => ['required', 'string'],
        ]);
        Category::whereId($id)->update($data);
        return redirect()->back()->with('success', 'Category data has been saved.');  
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('error', 'Category Deleted');
    }
}
