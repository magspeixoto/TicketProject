<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->get();

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
        ]);
    }

    public function edit(Article $article)
    {
        $categories = Category::all();

        return Inertia::render('Articles/Edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $article = Article::with(['category'])->findOrFail($id);

        return Inertia::render('Articles/Show', [
            'article' => $article,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'is_published' => 'boolean',
        ]);

        $article = Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'is_published' => 'boolean',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Articles/Create', [
            'categories' => $categories,
        ]);
    }
}
