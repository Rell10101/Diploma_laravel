<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        return view('home', compact('news'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    // Сохраняем только необходимые поля
    News::create($request->only(['title', 'content']));

    return redirect('/')->with('success', 'Объявление создано!');
}
}
