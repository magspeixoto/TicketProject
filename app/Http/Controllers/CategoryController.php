<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            
        ]);
    }
    public function create()
    {
        return inertia(
            'Categories/Create',
        );
    }

    public function store(Request $request)
    {
        Category::create(
            $request->validate([
                'name' => 'required',
                'description' => 'nullable'
            ])
        );

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return inertia('Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update(
            $request->validate([
                'name' => 'required|min:0|max:200',
                'description' => 'nullable'
            ])
        );

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        // Redirect to the same (or previous) page with a flash message
        return redirect()->route('categories.index');
    }
}
