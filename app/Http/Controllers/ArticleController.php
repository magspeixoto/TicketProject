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

        return Inertia::render
        ('Articles/Index', [
            'articles' => $articles,
            ]);
    }

    public function show($id)
    {
        /* $ticket = Ticket::with(['category', 'user', 'agent'])->findOrFail($id);
    $agents = User::where('role', 'agent')->get(); */


    return Inertia::render('Articles/Show', [
        'ticket' => $ticket,
        
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
            'priority' => 'required|in:low,medium,high',
        ]);

        return Article::create($validated);
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
            'priority' => 'sometimes|required|in:low,medium,high',
        ]);

        $article->update($validated);

        return $article;
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->noContent();
    }

    public function create()
    {
        $categories = Category::all();
        $articles = Article::all();

        return Inertia::render('Articles/Create', [
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }
}
